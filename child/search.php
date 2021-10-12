<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>予定を検索 </title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
      <link rel="stylesheet" href="css/all.min.css">
      <link rel="stylesheet" href="css/style.css">
  <!-- ↑順番で処理がされる。なので同じ部分を処理したときは最後のcss/style.cssが処理され、その内容が反映 -->
  </head>
  <body class="d-flex flex-column h-100">

  <!-- class 名はすべて Bootstrap で指定されている。これを変更するとレイアウトが反映されなくなる -->
  <header>
    <nav class="navbar navbar-expand-md  navbar-light bg-light  fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">カレンダー</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="add.php"><i class="fa fa-plus"></i> 追加</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php"><i class="fa fa-search"></i> 検索</a>
                    </li>
                </ul>
                <form class="d-flex" action="calendar.php">
                    <input type="text" name="ym" class="form-control me-2" placeholder="年月を選択" id="ymPicker">
                    <button class="btn btn-outline-dark text-nowrap" type="submit">表示</button>
                </form>
            </div>
        </div>
    </nav>
</header>



<main>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="text-center">予定を検索</h4>
                
                <form class="row row-cols-lg-auto g-2 align-items-center">
                    <div class="col-12 dp-parent">
                        <label class="visually-hidden" for="inputStartDate">開始日時</label>
                        <input type="text" name="start_date" id="inputStartDateTime" class="form-control search-date" placeholder="開始日">
                    </div>
                
                    <div class="col-12 dp-parent">
                        <label class="visually-hidden" for="inputEndDate">終了日時</label>
                        <input type="text" name="end_date" id="inlineFormInputGroupUsername" class="form-control search-date" placeholder="終了日">
                    </div>
                
                    <div class="col-12">
                        <label class="visually-hidden" for="inputTask">キーワード</label>
                        <input type="text" name="keyword" id="inputTask" class="form-control" placeholder="キーワード">
                    </div>
                
                    <div class="col-12 d-grid">
                        <button type="submit" class="btn btn-success">検索</button>
                    </div>
                </form>
 
                <h6 class="mt-5">検索結果:6件</h6>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th style="width: 20%;">開始日時</th>
                            <th style="width: 20%;">終了日時</th>
                            <th>予定</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2021/3/5 10:00</td>
                            <td>2021/3/5 11:25</td>
                            <td><a href="detail.php">予定１</a></td>
                        </tr>
                        <tr>
                            <td>2021/4/15 10:00</td>
                            <td>2021/5/15 12:00</td>
                            <td><a href="detail.php">予定２</a></td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4"><a href="search.php" class="btn btn-sm btn-link" role="button">検索条件をクリア</a></div>
            </div>
        </div>
    </div>
</main>




<footer class="footer py-3 mt-auto bg-light">
    <div class="container text-center">
        <span class="text-muted">&copy; My Calendar</span>
    </div>
</footer>
    

    <!-- JavaScript -->
    <!-- Code for Funからのコピーはjqueryのバージョンはjquery-3.5.1.min.jsとなっている -->
    <!-- 実際にリアルタイムではjquery-3.6.0.min.jsなので変更する -->
    <script src="js/bootstrap.min.js"></script>
      <script src="js/jquery-3.6.0.min.js"></script>
      <script src="js/moment.min.js"></script>
      <script src="js/ja.js"></script>
      <script src="js/bootstrap-datetimepicker.min.js"></script>
      <script>
        $(function () {
            $('#ymPicker').datetimepicker({
                format: 'YYYY-MM',
                locale: 'ja'
            });
            $('.search-date').datetimepicker({
              format: 'YYYY/MM/DD',
              locale: 'ja'
          });

        });
</script>
  </body>
  </html>
