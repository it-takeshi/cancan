<?php
session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$child_id = $_SESSION['child_id'];

$task_id = $_POST['task_id'];
$task_status = "2";

$sql = 'UPDATE new_task_table SET task_status=:task_status WHERE task_id=:task_id AND child_id=:child_id AND parent_id=:parent_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':task_status', $task_status, PDO::PARAM_STR);
                              // $task_status = "2";は親が確認チェック済みのタスク
$stmt->bindValue(':task_id', $task_id, PDO::PARAM_INT);
$stmt->bindValue(':child_id', $child_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

header('Location:parent_page.php');
exit();
