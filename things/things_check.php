<?php

// var_dump($_POST);
// exit();

session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();

$things_name = $_POST['things_name'];
$text_area = $_POST['textarea'];


if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  $uploaded_file_name3 = $_FILES['upfile']['name'];
  $temp_path1 = $_FILES['upfile']['tmp_name'];
  $directory_path1 = '../upload/';
  $extension = pathinfo($uploaded_file_name3, PATHINFO_EXTENSION);
  $unique_name = date('YmdHis') . md5(session_id()) . "." . $extension;
  $filename_to_save3 = $directory_path1 . $unique_name;
  if (is_uploaded_file($temp_path1)) {

    if (move_uploaded_file($temp_path1, $filename_to_save3)) {
      chmod($filename_to_save3, 0644);
    } else {
      exit('ERROR:アップロードできませんでした');
    }
  } else {
    exit('ERROR:画像がありません');
  }
} else {
  exit('error:画像が送信されていません');
}


if (isset($_FILES['upvideo']) && $_FILES['upvideo']['error'] == 0) {
  $uploaded_file_name4 = $_FILES['upvideo']['name'];
  $temp_path2 = $_FILES['upvideo']['tmp_name'];
  $directory_path2 = '../upload/';
  $extension = pathinfo($uploaded_file_name4, PATHINFO_EXTENSION);
  $unique_name = date('YmdHis') . md5(session_id()) . "." . $extension;
  $filename_to_save4 = $directory_path2 . $unique_name;
  if (is_uploaded_file($temp_path2)) {

    if (move_uploaded_file($temp_path2, $filename_to_save4)) {
      chmod($filename_to_save4, 0644);
    } else {
      exit('ERROR:アップロードできませんでした');
    }
  } else {
    exit('ERROR:動画がありません');
  }
} else {
  exit('error:動画が送信されていません');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ないようをかくにん</title>
<!-- Stylesheets -->
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="../css/things_check.css">
</head>

<body>
<header>
    <div class="img_title">
    <img src="../images/dog1.jpg" alt="" width="120px" height="120px">Can × Can
    </div>
    </header>
<h2>ないようをかくにん</h2>
<section class="check">
  
        <div>
              <p>
            <label for="things_name">ものごとタイトル</label>
            </p>
            <p>
              <?= $things_name ?>
            </p>
        </div>

          <div>
                <p>
              <label for="textarea">メモ</label>
              </p>
              <p>
                <?= $text_area ?>
              </p>
          </div>

          <div>
                <p>
                  <label for="upfile">しゃしん</label>
                </p>
                <p>
                <image src="<?= $filename_to_save3 ?>" width="100px"></image>
                </p>
          </div>

            <div>
                <p>
                  <label for="upvideo">どうが</label>
                </p>
                <p>
                <video src="<?= $filename_to_save4 ?>" controls autoplay muted width="200px" height="133px"></video>
                </p>
            </div>

  </section>

  <section class="submit">
          <form action="things_create.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="things_name" value="<?= $things_name ?>">
                <input type="hidden" name="text_area" value="<?= $text_area ?>">
                <input type="hidden" name="filename_to_save3" value="<?= $filename_to_save3 ?>">
                <input type="hidden" name="filename_to_save4" value="<?= $filename_to_save4 ?>">
                <button type="submit">とうろく</button>
          </form>

          <div class="">
              <a href="things_input.php">入力へ戻る</a>
          </div>
  </section>

  
</body>

</html>