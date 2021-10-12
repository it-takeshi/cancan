<?php
// var_dump($_POST);
// exit(); OK
// array(4) { ["task_name"]=> string(18) "歯医者へ行く" ["start_datetime"]=> string(16) "2021/10/08 21:40" ["filename_to_save"]=> string(60) "../upload/20211008062907ceaa980cb5f80557243ac1c01922362c.png" ["color"]=> string(9) "bg-danger" }

session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$child_id = $_SESSION['child_id'];

$task_name = $_POST['task_name'];
$start_datetime = $_POST['start_datetime'];
// $task_date = $_POST['task_date'];
// $task_time = $_POST['task_time'];
$color = $_POST['color'];
$image = $_POST['filename_to_save'];
$task_status = "0";

$sql = 'INSERT INTO new_task_table (task_id, child_id, parent_id, task_name, start_datetime, color, image, task_status, created_at, updated_at) VALUES (NULL, :child_id, :parent_id, :task_name, :start_datetime, :color, :image, :task_status, sysdate(), sysdate())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $child_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':task_name', $task_name, PDO::PARAM_STR);
$stmt->bindValue(':start_datetime', $start_datetime, PDO::PARAM_STR);
// $stmt->bindValue(':task_date', $task_date, PDO::PARAM_STR);
// $stmt->bindValue(':task_time', $task_time, PDO::PARAM_STR);
$stmt->bindValue(':color', $color, PDO::PARAM_STR);
$stmt->bindValue(':image', $image, PDO::PARAM_STR);
$stmt->bindValue(':task_status', $task_status, PDO::PARAM_STR);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}
// 予定詳細画面に遷移
header('Location:parent_page.php?ymd='.date('Y-m-d', strtotime($start_datetime)));
exit();
