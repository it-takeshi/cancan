<?php
session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$parent_id = $_SESSION['parent_id'];
$id = $_GET["id"];

$sql = "DELETE FROM things_table WHERE things_id=:things_id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':things_id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:things_list.php");
  exit();
}
