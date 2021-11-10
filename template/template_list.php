<?php
session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();

$template_name = $_POST['template_name'];
$template_image = $_POST['filename_to_save2'];

$sql = 'SELECT * FROM template_table LIMIT 20';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $templates = $stmt->fetchALL(PDO::FETCH_ASSOC);
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
for ($i = 0; $i < count($templates); $i++) {
  // count()関数で$templatesの配列の数を取る
    $output .= "<ul>";
    $output .= "<li><img src='{$templates[$i]["template_image"]}' width='100px'></li>";
    $output .= "<li>{$templates[$i]["template_name"]}</li>";
    $output .= "<li>
                    <form action='../parent/parent_temple_check_create.php' method='POST'>
                      <input type='hidden' name='template' value={$templates[$i]["template_id"]}>
                      
                      <button id='complete_btn' type='submit' >つかう</button>
                    </form>
                </li>";
    // $output .= "<li><a href='template_delete.php?id={$templates[$i]["template_id"]}'>削除</a></li>";

    $output .= "</ul>";
  }


?>

<!DOCTYPE html>
<html lang="ja" >
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
      <!-- Stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/template_list.css">
</head>
  <body>

  <header>
      <div class="img_title">
    <img src="../images/dog1.jpg" alt="" width="90px" height="90px">Can × Can
    </div>
    </header>
  
  <h2>つかうテンプレートをえらんでください</h2>
  <section>
    <?= $output ?>
    </section>
    
    <div class="button">
    <a href="template_input.php">あらたに作る</a>
        <a href="../parent/parent_page.php">もどる</a>
      </div>
<!--     
  <footer class="footer py-3 mt-auto bg-light">
    <div class="container text-center">
        <span class="text-muted">&copy; Can Can</span>
    </div>
    <div class="container text-center">
        <span class="text-muted">&copy; Can Can</span>
    </div>
    <div class="container text-center">
        <span class="text-muted">&copy; Can Can</span>
    </div>
</footer> -->
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

