<?PHP
session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>タスク入力</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="../css/task_input.css">
</head>

<body>

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

<section>
  <form action="parent_task_check.php" method="post"  enctype="multipart/form-data">
        <p>
        <label>
        いつから？：
        <input type="text" name="start_datetime" id="inputStartDateTime"
        placeholder="はじめる時間を入れよう。" autocomplete="off">
        </label>
        </p>
        <p>
        <label>
        やること：
        <input type="text" name="task_name">
        </label>
        </p>

        <p>
        <label class="upload-label"> がぞう：
        <input type="file" name="upfile" accept="image/*" > 
        <!-- capture="camera" -->
        </label>
        </p>

        <p>
        <label> カラー：
        <select name="color" id="selectColor" class="form-select bg-light">
                                    <option value="bg-light" selected>白</option>
                                    <option value="bg-danger">赤</option>
                                    <option value="bg-warning">オレンジ</option>
                                    <option value="bg-primary">青</option>
                                    <option value="bg-info">水色</option>
                                    <option value="bg-success">緑</option>
                                    <option value="bg-dark">黒</option>
                                    <option value="bg-secondary">グレー</option>
                                </select>
        </label>
        </p>
        <p>
        <input type="submit" value="かくにん">
        </p>
  </form>
</section>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <!-- jQuery datetimepicker -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />

<!-- <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery-3.6.0.min.js"></script>
        <script src="../js/moment.min.js"></script>
        <script src="../js/ja.js"></script>
        <script src="../js/bootstrap-datetimepicker.min.js"></script> -->
<script>

$(function() {
    $.datetimepicker.setLocale('ja');
  $('#inputStartDateTime').datetimepicker({
    
    allowTimes:[
    
    '06:00', '06:10', '06:20', '06:30', '06:40', '06:50', 
    '07:00', '07:10', '07:20', '07:30', '07:40', '07:50', 
    '08:00', '08:10', '08:20', '08:30', '08:40', '08:50', 
    '09:00', '09:10', '09:20', '09:30', '09:40', '09:50', 
    '10:00', '10:10', '10:20', '10:30', '10:40', '10:50', 
    '11:00', '11:10', '11:20', '11:30', '11:40', '11:50', 
    '12:00', '12:10', '12:20', '12:30', '12:40', '12:50', 
    '13:00', '13:10', '13:20', '13:30', '13:40', '13:50', 
    '14:00', '14:10', '14:20', '14:30', '14:40', '14:50', 
    '15:00', '15:10', '15:20', '15:30', '15:40', '15:50', 
    '16:00', '16:10', '16:20', '16:30', '16:40', '16:50', 
    '17:00', '17:10', '17:20', '17:30', '17:40', '17:50', 
    '18:00', '18:10', '18:20', '18:30', '18:40', '18:50', 
    '19:00', '19:10', '19:20', '19:30', '19:40', '19:50', 
    '20:00', '20:10', '20:20', '20:30', '20:40', '20:50', 
    '21:00', '21:10', '21:20', '21:30', '21:40', '21:50', 
    '22:00', '22:10', '22:20', '22:30', '22:40', '22:50', 
    '23:00', '23:10', '23:20', '23:30', '23:40', '23:50',

    ]
    
  });
});
</script>
</body>
</html>

<!-- // $(function () {
//                 $('#ymPicker').datetimepicker({
//                     format: 'YYYY-MM',
//                     locale: 'ja'
//                 });
//             $('.task-datetime').datetimepicker({
//                 dayViewHeaderFormat: 'YYYY年 MMMM',
//                 format: 'YYYY/MM/DD HH:mm',
//                 locale: 'ja',
//             });
//             $('#selectColor').bind('change', function(){
//                 $(this).removeClass();
//                 $(this).addClass('form-select').addClass($(this).val());
//             });
//         }); -->

