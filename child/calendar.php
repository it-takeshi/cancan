<?PHP
// 500エラーが発生した場合の対処法 PHPプログラムの記述ミス確認は下記を記載
// ini_set("display_errors", 1);
// error_reporting(E_ALL);

session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$user_id = $_SESSION['user_id'];
$child_name =$_SESSION['child_name'];

    // 前月・次月リンクが押された場合は、GETパラメータから年月を取得
    if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];

    } else {
    // 今月の年月を表示
    // 年月は Y-m（2021-03, 2022-11）というフォーマットで用意
    $ym = date('Y-m');
    // var_dump($ym);
    // exit();
    // string(7) "2021-09"
    }

    // タイムスタンプを作成し、フォーマットをチェックする
    $timestamp = strtotime($ym . '-01');
    if ($timestamp === false) {
        $ym = date('Y-m');
        $timestamp = strtotime($ym . '-01');
    }

    // 表示するカレンダー月が何日まであるかを取得
    // フォーマットtは 月の日数（何日まであるか）を意味する。値は28~31
    $day_count = date('t', $timestamp);
    // var_dump($day_count);
    // exit();
    // // string(2) "30" ←現在月（9月）の日数を取得

    // 表示するカレンダー月の最初の日（１日）が何曜日かを取得
    // フォーマットNはISO-8601 形式の、曜日の数値表現。戻り値は1（月曜日）から 7（日曜日）
    $youbi = date('N', $timestamp);
    // var_dump($youbi);
    //   exit();
    //   string(1) "3" ←現在月（9月）の最初の日の曜日を取得。3なので最初の日（9月1日）は水曜日
    //  つまり9月の場合 9月1日は$youbiが3、9月2日は$youbiが4、9月30日は$youbiが32となる

    // / カレンダーのタイトルを作成例）2021年3月
    $html_title = date('Y年n月', $timestamp);

    // 前月と次月のリンク calendar.php?ym=2021-02 に使う次の年月と前の年月を取得
    $prev = date('Y-m', strtotime('-1 month', $timestamp));
    $next = date('Y-m', strtotime('+1 month', $timestamp));

    // 今日の日付を Y-m-d（2021-03-05, 2022-08-01）というフォーマットで用意
    // 今日の日付例）2021-03-05
    $today = date('Y-m-d');

    // カレンダー作成の準備 空の配列
    $weeks = [];
    $week = '';

    // 第１週目：空のセルを追加
    // 例）１日が木曜日だった場合、$youbiは4で木曜日。なので月曜日から水曜日の３つ分の空セルを追加する
    // 例）１日が水曜日だった場合、$youbiは3で水曜日。なので月曜日から火曜日の2つ分の空セルを追加する
    // str_repeat('繰り返す文字列', 繰り返す回数)
    $week .= str_repeat('<td></td>', $youbi-1);

    // データベースに接続
    $pdo = connect_to_db();

    // カレンダー作成
    for ( $day = 1; $day <= $day_count; $day++, $youbi++) {

        // ⭐️カレンダーの日付をクリックした時に、その日付の詳細画面に遷移！！！
        // 作成中の日付を 2021-04-08 というフォーマットで用意している？
        $date = $ym . '-' . sprintf('%02d', $day);
        // var_dump($date);
        // exit(); ブラウザ表示している月の最初の日を取得
        // string(10) "2021-09-01"
        // string(10) "2021-05-01"

        // // ↓ユーザーと日付から予定を取得
        
                    $sql = 'SELECT * FROM new_task_table WHERE child_id=:child_id AND CAST(start_datetime AS DATE) = :start_datetime ORDER BY start_datetime ASC';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':child_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindValue(':start_datetime', $date, PDO::PARAM_STR);
                    $status = $stmt->execute();
                    if ($status == false) {
                    $error = $stmt->errorInfo();
                    echo json_encode(["error_msg" => "{$error[2]}"]);
                    exit();
                    } else {
                        $rows = $stmt->fetchAll();
                    // ↑予定を取得  fetchAllに(PDO::FETCH_ASSOC)を付けるとカラム名表示
                    }
                    
        // 今日の日付を表す today クラスをつける
        if ($date == $today) {
            $week .= '<td class="today">';
        } else {
            $week .= '<td>';
        }
                  // ↓このリンクを例えばchild_page.phpへ変える
        $week .= '<a href="child_page.php?ymd=' . $date . '">' . $day;

        if (!empty($rows)) {
        $week .= '<div class="badges">';
            foreach ($rows as $row) {
                $task = date('H:i', strtotime($row['start_datetime'])) . ' ' . $row['task_name'];
                // ↑例 10:30 買い物に行く といった開始時間とタスクが$taskに入る
                $week .= '<span class="badge text-wrap ' . $row['color'] . '">' . $task . '</span>';
                        // ↑$taskをspanクラスで囲っている
                }
                $week .= '</div>';
            }
            $week .= '</a></td>';

        // 日曜日、または、最終日の場合は
        if ($youbi % 7 == 0 || $day == $day_count) {
            // 日曜日の $youbi の値は必ず 7 の倍数。なので7で割ると0になる
            // $day と $day_count が一致した場合は、月の最後の日付になったことになる

            if ($day == $day_count && $youbi % 7 != 0) {
                // 月の最終日の場合、空セルを追加
                // 例）最終日が金曜日の場合、土・日曜日の空セルを追加
                $week .= str_repeat('<td></td>', 7 - $youbi % 7);
            }

            // weeks配列にtrと$weekを追加する
            $weeks[] = '<tr>' . $week . '</tr>';

            // weekをリセット
            $week = '';
            }
    }
// <!----------------------------------------------------------- -->
// ↑ カレンダー作成のfor 文ここまで

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body class="d-flex flex-column h-100">

<header>
    <nav class="navbar navbar-expand-md  navbar-light bg-light  fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="calendar.php"><?= $child_name ?>さんのカレンダー</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="child_task_input.php"><i class="fa fa-plus"></i> ついか</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php"><i class="fa fa-search"></i> えらぶ</a>
                    </li>
                    <li class="nav-item">
                                <a class="nav-link" href="../log/logout.php"><i class="fas fa-sign-out-alt"></i> ログアウト</a>
                            </li>
                </ul>
                <form class="d-flex">
                    <input type="text" name="ym" class="form-control me-2" placeholder="年月をえらぶ" id="ymPicker">
                    <button class="btn btn-outline-dark text-nowrap" type="submit">ひょうじ</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<!-- カレンダー表示ここから＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ -->
<main>
    <div class="container">
        <table class="table table-bordered calendar">
            <thead>
            <tr class="head-cal fs-4">
                <th colspan="1" class="text-start"><a href="calendar.php?ym=<?= $prev; ?>">&lt;</a></th>
            <!-- $prev = date('Y-m', strtotime('-1 month', $timestamp)); $prevは前月の値を取得した変数 -->

                    <th colspan="5"><?= $html_title; ?></th>
                                <!-- ↑$html_title = date('Y年n月', $timestamp);のこと。今月が表示 -->
                    <th colspan="1" class="text-end"><a href="calendar.php?ym=<?= $next; ?>">&gt;</a></th>
            <!-- $next = date('Y-m', strtotime('+1 month', $timestamp));  $nextは翌月の値を取得した変数-->

                </tr>
                <tr class="head-week">
                    <th>月</th>
                    <th>火</th>
                    <th>水</th>
                    <th>木</th>
                    <th>金</th>
                    <th>土</th>
                    <th>日</th>
                </tr>
            </thead>
            <tbody>
                    
                <!--  $weeks 配列を HTML 部分に出力 -->
                    <?php foreach($weeks as $week){
                        echo $week;
                    }?>

            </tbody>
        </table>
    </div>
</main>
<!-- カレンダー表示ここまで＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ -->


<footer class="footer py-3 mt-auto bg-light">
    <div class="container text-center">
        <span class="text-muted">&copy; Can ✖️ Can</span>
    </div>
</footer>
    

    <!-- JavaScript -->
    <!-- Code for Funからのコピーはjqueryのバージョンはjquery-3.5.1.min.jsとなっている -->
    <!-- 実際にリアルタイムではjquery-3.6.0.min.jsなので変更する -->
    <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery-3.6.0.min.js"></script>
        <script src="../js/moment.min.js"></script>
        <script src="../js/ja.js"></script>
        <script src="../js/bootstrap-datetimepicker.min.js"></script>
        <script>
            
        $(function () {
            $('#ymPicker').datetimepicker({
                format: 'YYYY-MM',
                locale: 'ja'
            });
            $('.task-datetime').datetimepicker({
            dayViewHeaderFormat: 'YYYY年 MMMM',
            format: 'YYYY/MM/DD HH:mm',
            locale: 'ja',
        });
        $('.search-date').datetimepicker({
            format: 'YYYY/MM/DD',
            locale: 'ja'
            });
        $('#selectColor').bind('change', function(){
            $(this).removeClass();
            $(this).addClass('form-select').addClass($(this).val());
        });
        });
</script>
    </body>
    </html>