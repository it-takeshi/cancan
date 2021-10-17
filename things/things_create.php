<?php
//  var_dump($_POST);
//  exit();

session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$child_id = $_SESSION['child_id'];

$things_name = $_POST['things_name'];
$text_area = $_POST['text_area'];

$picture = $_POST['filename_to_save3'];
$movie = $_POST['filename_to_save4'];

$sql = 'INSERT INTO things_table (things_id,
child_id, parent_id, things_name, memo, picture, movie, created_at, updated_at) VALUES (NULL, :child_id, :parent_id,:things_name, :memo, :picture, :movie, sysdate(), sysdate())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $child_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':things_name', $things_name, PDO::PARAM_STR);
$stmt->bindValue(':memo', $text_area, PDO::PARAM_STR);
$stmt->bindValue(':picture', $picture, PDO::PARAM_STR);
$stmt->bindValue(':movie', $movie, PDO::PARAM_STR);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}
// 画面に遷移
header('Location:things_list.php');
exit();
