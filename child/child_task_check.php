<?PHP
session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();

$task_name = $_POST['task_name'];
$start_datetime = $_POST['start_datetime'];
$color = $_POST['color'];
// $task_date = $_POST['task_date'];
// $task_time = $_POST['task_time'];

    if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
    $uploaded_file_name = $_FILES['upfile']['name'];
    $temp_path = $_FILES['upfile']['tmp_name'];
    $directory_path = '../upload/';
    $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
    $unique_name = date('YmdHis') . md5(session_id()) . "." . $extension;
    $filename_to_save = $directory_path . $unique_name;
    if (is_uploaded_file($temp_path)) {

        if (move_uploaded_file($temp_path, $filename_to_save)) {
        chmod($filename_to_save, 0644);
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
<meta name="viewport" content="width=device-width">
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
<body class="">
    <header>
        <p>Can × Can</p>
    </header>
    <section class="check">
        <h1>ないようをかくにん</h1>
        <p>
        <label for="task_name">やること</label>
        </p>
        <p>
            <?= $task_name ?>
        </p>

        <p>
        <label for="start_datetime">いつから？</label>
        </p>
        <p>
            <?= $start_datetime ?>
        </p>  

        <p>
        <label for="upfile">しゃしん</label>
        </p>
        <p>
            <image src="<?= $filename_to_save ?>" width="20px"></image>
        </p>
    </section>
    <section class="submit">
        <form action="child_task_create.php" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="task_name" value="<?= $task_name ?>">
            <input type="hidden" name="start_datetime" value="<?= $start_datetime ?>">
            <input type="hidden" name="filename_to_save" value="<?= $filename_to_save ?>">
            <input type="hidden" name="color" value="<?= $color ?>">
            <button type="submit">とうろく</button>
        </form>
        <div>
            <a href="child_task.input.php">もどる</a>
        </div>
    </section>
    <footer>© Can & Can</footer>

    <script src="../js/bootstrap.min.js"></script>
            <script src="../js/jquery-3.6.0.min.js"></script>
            <script src="../js/moment.min.js"></script>
            <script src="../js/ja.js"></script>
            <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script></script>
</body>
</html>
