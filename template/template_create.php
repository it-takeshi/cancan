<?php
// var_dump($_POST);
// exit();

session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();

$template_name = $_POST['template_name'];
// $text_area = $_POST['text_area'];

$template_image = $_POST['filename_to_save2'];

$sql = 'INSERT INTO template_table (template_id, template_name, template_image, created_at, updated_at) VALUES (NULL, :template_name, :template_image,  sysdate(), sysdate())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':template_name', $template_name, PDO::PARAM_STR);
$stmt->bindValue(':template_image', $template_image, PDO::PARAM_STR);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}
// 画面に遷移
header('Location:template_list.php');
exit();
