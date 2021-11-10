<?php
session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$parent_id = $_SESSION['parent_id'];
$id = $_GET["id"];

$sql = "DELETE FROM new_task_table WHERE task_id=:task_id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':task_id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:parent_page.php");
  exit();
}
