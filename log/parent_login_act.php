<?php
session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();

$email = $_POST["email"];
$password = $_POST["password"];

$sql = 'SELECT * FROM users_table WHERE email=:email AND password=:password';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $val = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$val) {
    echo "<p>ログインに失敗しました</p>";
    echo '<div><a href="parent_login.php">ログイン</a></div>';
    echo '<div><a href="../home.php">新規登録</a></div>';
    exit();
  } else {
    $sql = 'SELECT * FROM relation_table WHERE parent_id=:user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $val['user_id'], PDO::PARAM_INT);
    $status = $stmt->execute();
    if ($status == false) {
      $error = $stmt->errorInfo();
      echo json_encode(["error_msg" => "{$error[2]}"]);
      exit();
    } else {
      $relation_data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if ($relation_data) {
      $_SESSION = array();
      $_SESSION['session_id'] = session_id();
      // ↑ログインしたタイミングでsession_idを取得してSESSION変数に入れておく
      $_SESSION['user_id'] = $val['user_id'];
      $_SESSION['child_id'] = $relation_data['child_id'];
      header('Location:../parent/parent_page.php');
      exit();
    } else {
      $_SESSION = array();
      $_SESSION['session_id'] = session_id();
      $_SESSION['user_id'] = $val['user_id'];
      header('Location:../parent/parent_page.php');
      exit();
    }
  }
}
