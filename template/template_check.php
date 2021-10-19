<?php
session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();

$template_name = $_POST['template_name'];
// $text_area = $_POST['text_area'];


if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  $uploaded_file_name2 = $_FILES['upfile']['name'];
  $temp_path = $_FILES['upfile']['tmp_name'];
  $directory_path = '../upload/';
  $extension = pathinfo($uploaded_file_name2, PATHINFO_EXTENSION);
  $unique_name = date('YmdHis') . md5(session_id()) . "." . $extension;
  $filename_to_save2 = $directory_path . $unique_name;
  if (is_uploaded_file($temp_path)) {

    if (move_uploaded_file($temp_path, $filename_to_save2)) {
      chmod($filename_to_save2, 0644);
    } else {
      exit('ERROR:アップロードできませんでした');
    }
  } else {
    exit('ERROR:画像がありません');
  }
} else {
  exit('error:画像が送信されていません');
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ないようをかくにん</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- jQuery datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<link rel="stylesheet" href="../css/task_check.css">
 
</head>

<body>

<header>
        <a href="index.html">Can × Can</a>
    </header>

        <!-- <nav>
            <ul>
            <li><a href="index.html">トップ</a></li>
            <li><a href="about.html">サイトについて</a></li>
            <li><a href="contact.html">お問い合わせ</a></li>
            </ul>
        </nav> -->

<section class="check">
  <h1>ないようをかくにん</h1>
    <div>
      <p>
    <label for="template_name">テンプレート名</label>
    </p>
    <p>
      <?= $template_name ?>
    </p>
    </div>

    <div>
    <p>
      <label for="upfile">しゃしん</label>
    </p>
    <p>
    <image src="<?= $filename_to_save2 ?>" width="100px"></image>
    </p>
    </div>
  </section>

  <section class="submit">
  <form action="template_create.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="template_name" value="<?= $template_name ?>">
    <input type="hidden" name="filename_to_save2" value="<?= $filename_to_save2 ?>">
    <!-- <input type="hidden" name="text_area" value="<?= $text_area ?>"> -->
    <button type="submit">とうろく</button>
  </form>

  <div class="">
      <a href="template_input.php">入力へ戻る</a>
    </div>

  </section>

</body>

</html>