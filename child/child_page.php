<?PHP
session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$parent_id = $_SESSION['parent_id'];
$start_datetime = $_POST['start_datetime'];
$task_status = "0";
// ↓親が確認済みのタスクを表示させる変数
$parent_checked_task_status = "2";

// 当日情報をGETで受信（ymd)
$ymd = $_GET['ymd'];
// var_dump($ymd);
// exit();
// string(10) "2021-09-28" 確認OK

// ymdの存在・形式チェック
if (!isset($_GET['ymd']) || strtotime($_GET['ymd']) === false) {
  // パラメータが空 or 無効な文字列
  header('Location:calendar.php');
  exit();
}

$ymd_formatted = date('Y年n月j日', strtotime($ymd));
// var_dump($ymd_formatted);
//  exit(); string(16) "2021年9月28日" OK
$title = $ymd_formatted;

$sql = 'SELECT * FROM users_table WHERE user_id=:user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($user_data);
  // exit();  OK
  // ↑SELECT文で取り出した全ての情報（該当する子供の情報）が連想配列で（オブジェクト型）
  // array(7) { ["user_id"]=> string(2) "21" ["name"]=> string(15) "ジェイムズ" ["email"]=> NULL ["password"]=> NULL ["category"]=> string(5) "child" ["created_at"]=> string(10) "2021-09-28" ["updated_at"]=> string(10) "2021-09-28" }
}

$sql = 'SELECT * FROM new_task_table WHERE child_id=:child_id AND parent_id=:parent_id AND CAST(start_datetime AS DATE) = :start_datetime AND task_status=:task_status ORDER BY start_datetime ASC';
                                              // ↑$task_status = "0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
$stmt->bindValue(':start_datetime', $ymd, PDO::PARAM_STR);
$stmt->bindValue(':task_status', $task_status, PDO::PARAM_STR);
                                    // ↑$task_status = "0" まだおわってないタスクが表示;
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $my_task = $stmt->fetchALL(PDO::FETCH_ASSOC);
  // var_dump($my_task);
  // exit();  OK
  // ↑SELECT文で取り出した$task_status = "0"の状態（おわってない）タスクの全ての情報が連想配列で（オブジェクト型）
   
  //  var_dump($my_task);
  //  exit();
  // array(2)
  //  { [0]=> array(10) { ["task_id"]=> string(2) "10" ["child_id"]=> string(2) "19" ["parent_id"]=> string(2) "18" ["task_name"]=> string(12) "宿題する" ["task_date"]=> string(10) "2021-09-27" ["task_time"]=> string(5) "15:06" ["image"]=> string(60) "../upload/20210927060541ab69c856f3aea1291565cacb4ae109a6.png" ["task_status"]=> string(1) "0" ["created_at"]=> string(19) "2021-09-27 15:05:45" ["updated_at"]=> string(19) "2021-09-27 15:05:45" } 
}

$sql = 'SELECT * FROM new_task_table WHERE child_id=:child_id AND parent_id=:parent_id AND CAST(start_datetime AS DATE) = :start_datetime AND task_status=:task_status ORDER BY start_datetime ASC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
$stmt->bindValue(':start_datetime', $ymd, PDO::PARAM_STR);
$stmt->bindValue(':task_status', $parent_checked_task_status, PDO::PARAM_STR);
                                  //$parent_checked_task_status = "2"; parentのtask_response.phpで親が確認済みのタスク 
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $parent_checked_task= $stmt->fetchALL(PDO::FETCH_ASSOC);
// var_dump($parent_checked_task);
// exit(); 親がチェック済みのタスクの一覧が配列で取得
if ($parent_checked_task) {
  $parent_checked_task_output ="<tr><td>できたね！</td><td></td><td class='image'></td><td></td></tr>";
  for ($i = 0; $i < count($parent_checked_task); $i++) {
     // count()関数で$parent_checked_taskの配列の数を取る
    $start_time = date('H:i', strtotime($parent_checked_task[$i]["start_datetime"]));
  
    $parent_checked_task_output .= "<tr>";

    $parent_checked_task_output .= "<td>{$start_time}</td>";

    $parent_checked_task_output .= "<td>{$parent_checked_task[$i]["task_name"]}</td>";

    $parent_checked_task_output .= "<td><img src='{$parent_checked_task[$i]["image"]}' width='30px'></td>";
    
    $parent_checked_task_output .= "<td><img src='../images/good.jpg' width='20px'></td>";
    $parent_checked_task_output .= "</tr>";
  }
} else {
  $parent_checked_task_output = "<tr><td class='image'></td><td></td><td></td><td></td><td></td></tr>";
}
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>こどものマイページ</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="../css/child_page.css">
</head>

<body >
    <header>
            <nav class="navbar navbar-expand-md  navbar-light bg-light  fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="calendar.php"  id="sound3_button"><i class="far fa-calendar-alt"></i>カレンダー</a>

                    <p><?= $user_data['name'] ?>さんの<br>マイページ</p>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="child_task_input.php" id="sound3_button"><i class="fa fa-plus"></i> ついか</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../log/logout.php" id="sound3_button"><i class="fas fa-sign-out-alt"></i> ログアウト</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
    </header>

<main>
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h4 class="text-center"><?= $ymd_formatted; ?></h4>

    <!-- もし$rowsが空でなければ以下を実行。空であれば 
                            「予定がありません。予定の追加は」が表示-->
        <?php if (!empty($my_task)):?>
                
            <table class="table">
                <thead>
                    <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 15%;"><i class="far fa-clock"></i></th>
                    <th style="width: 40%;"><i class="fas fa-list"></i></th>
                    <th style="width: 20%;"></th>
                    <th style="width: 25%;"></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($my_task as $row): ?>
                        <?php
                            $color = str_replace('bg', 'text', $row['color']);
                            $start = date('H:i', strtotime($row['start_datetime']));
                            $start_date = date('Y-m-d', strtotime($row['start_datetime']));
            
                        ?>
                    <tr>
                    <td><i class="fas fa-square <?= $color; ?>"></i></td>
                    <td><?= $start; ?> ~ <?= $end; ?></td>
                    <td><?= $row['task_name']; ?></td>
                    <td>
                        <!-- <a href="edit.php?id=<?= $row['task_id']; ?>" class="btn btn-sm btn-link">
                        編集 -->
                        <img src='<?= $row['image'];?> ' width="50px"></a>
                            <!--↑このファイル名ではない対応用のリンク先phpファイルを作成しないといけない -->
                    </td>
                    <!-- たっせい⭐️ボタン -->
                    <td>
                        <form action='task_complete.php' method='POST'>
                        <input type="hidden" id="star" name='task_id' value="<?= $row['task_id'] ?>"> 
                        <button id='complete_btn' type='submit' class="c-button">
                                <img src="../images/star-6577079__480.webp" alt="" width="50px">
                                <!-- <img src="../images/bells-2957570__340.webp" alt="" width="40px"> -->
                        </button> 
                        </form>
                        <audio id="click_sound" preload="auto">
                              <source src="../audio/click21.mp3"  type="audio/mp3">
                        </audio>

                    <!-- たっせい⭐️ボタン -->

                        <!-- <a href=""><i class="far fa-smile-wink"></i></a> -->
                    
                    <a href="javascript:void(0);" onclick="var ok=confirm('このよていを消してよろしいですか？'); 
                        if(ok) location.href='child_task_delete.php?id=<?= $row['task_id']; ?>'"class="btn btn-sm btn-link">
                        <i class="fas fa-times-circle fa-lg" ></i>
                    </a> 
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-dark" role="alert">
                <!-- 今日は○月○日です。 -->
                <a href="child_task_input.php" class="alert-link" id="sound3_button"><i class="fas fa-plus-circle"></i></a>ボタンを押して今日のやることを<br>
            いれましょう<br>

            <a href="calendar.php" class="alert-link" id="sound3_button"><i class="far fa-calendar-alt"></i></a>
            他の日はカレンダーボタンを押して<br>
            いれましょう 。
        </div>
<?php endif;?>
</div>
</div>
</div>
<div class="button" id="sound3_button"><a href="../things/things_list_child.php">もの・ことかくにん</a></div>
</main>

<section id="parent_checked_task_output">
    <p>↓チェック！</p> 
    <table>
        <tr>
          <td> <?= $parent_checked_task_output ?></td>
        </tr>
    </table>    
</section>

<div>
    <input type="button" value="こうしん" onclick="koshin()"  id="koshin">
</div>
        <audio id="click_sound2" preload="auto">
              <source src="../audio/click5.mp3"  type="audio/mp3">
        </audio>

        <audio id="click_sound3" preload="auto">
              <source src="../audio/click31.mp3"  type="audio/mp3">
        </audio>

<!-- java script! -->
<script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/ja.js"></script>
  <script src="../js/bootstrap-datetimepicker.min.js"></script>

<script>
  window.onload = () => {
        const se = document.querySelector('#click_sound');
        document.querySelector("#complete_btn").addEventListener("click", () => {
            se.play();
        });
    };

    window.onload = () => {
        const se2  = document.querySelector('#click_sound2');
        document.querySelector("#koshin").addEventListener("click", () => {
            se2.play();
        });
    };

    window.onload = () => {
        const se3  = document.querySelector('#click_sound3');
        document.querySelector("#sound3_button").addEventListener("click", () => {
            se3.play();
        });
    };


//ページ遷移
$("#complete_btn").on("click", function() {
  setTimeout(function() {
    location.href= "child_cel.php";
  }, 2000);
});

 function koshin() {
      location.reload();

    }

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