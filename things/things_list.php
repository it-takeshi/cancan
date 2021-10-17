<?php
session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$child_id = $_SESSION['child_id'];
$things_name = $_POST['things_name'];
$text_area = $_POST['text_area'];
$picture = $_POST['filename_to_save3'];
$movie = $_POST['filename_to_save4'];


$sql = 'SELECT * FROM users_table WHERE user_id=:user_id ';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
}


$sql = 'SELECT * FROM things_table  WHERE child_id=:child_id AND parent_id=:parent_id ';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $child_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $things = $stmt->fetchALL(PDO::FETCH_ASSOC);
  //  var_dump($templates);
  //  exit();
  //  array(3)
  //  { [0]=> 
    // array(5) { ["template_id"]=> string(1) "1" ["template_name"]=> string(21) "スーパーに行く" ["template_image"]=> string(60) "../upload/20210929143707afbb2f1b5012faf0d1e27765b03e58d3.png" ["created_at"]=> string(19) "2021-09-29 14:39:33" ["updated_at"]=> string(19) "2021-09-29 14:39:33" } 
  // [1]=> 
  // array(5) { ["template_id"]=> string(1) "3" ["template_name"]=> string(24) "びょういんへ行く" ["template_image"]=> string(60) "../upload/2021092914403155825ec8aa0e62944d53fc35a8b9a762.png" ["created_at"]=> string(19) "2021-09-29 14:40:32" ["updated_at"]=> string(19) "2021-09-29 14:40:32" } 
  // [2]=>
  //  array(5) { ["template_id"]=> string(1) "4" ["template_name"]=> string(21) "はいしゃへ行く" ["template_image"]=> string(60) "../upload/202109291440528383dcf6e01f51d2c638c17a84d711f8.png" ["created_at"]=> string(19) "2021-09-29 14:40:53" ["updated_at"]=> string(19) "2021-09-29 14:40:53" } 
}
$output = "";
for ($i = 0; $i < count($things); $i++) {
  // count()関数で$thingsの配列の数を取る
    $output .= "<ul>";
    $output .= "<li>{$things[$i]["things_name"]}</li>";
    $output .= "<li>{$things[$i]["memo"]}</li>";
    $output .= "<li><img src='{$things[$i]["picture"]}' width='70px'></li>";
    $output .= "<li><video src='{$things[$i]["movie"]}'controls autoplay muted width='200px' height='133px'></video></li>";

    $output .= "<li>
                    <form action='../parent/parent_temple_check_create.php' method='POST'>
                      <input type='hidden' name='template' value={$templates[$i]["template_id"]}>
                      
                      <button id='complete_btn' type='submit'>つかう</button>
                    </form>
                </li>";
    $output .= "</ul>";
  }

?>

<!DOCTYPE html>
<html lang="ja" >
<head>
      <!-- Stylesheets -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/things_list.css">
</head>
<body>
<header>
      <p><a href="#">Can × Can</a></p>
</header>
<h1>もの・ことリスト</h1>
<section>
    <?= $output ?>
</section>
<div class="">
        <a href="things_input.php">新しく作る</a>
        <a href="../parent/parent_page.php">もどる</a>
      </div>

</body>
<!-- java script! -->
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

