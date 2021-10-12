<?php
include("../functions.php");
$pdo = connect_to_db();

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$category = "parent";

// メールアドレスが既に使われていないかテェック ------------------------------------------------
$sql = 'SELECT * FROM users_table WHERE email=:email';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$status = $stmt->execute();
$val = $stmt->fetch(PDO::FETCH_ASSOC);
if ($val) {
  echo "<p>メールアドレスは既に使用されています</p>";
  echo '<a href="../log/login.php">ログイン</a>';
  echo '<a href="../account_create/parent_create.php">新規登録</a>';
  exit();
} else {
  // 使われていないメールアドレスなら users_table に 親として DATAセット ------------------------------------------------
  $sql =  'INSERT INTO users_table (user_id, name, email, password, category, created_at, updated_at) VALUES (NULL, :name, :email, :password, :category, sysdate(), sysdate())';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  $stmt->bindValue(':category', $category, PDO::PARAM_STR);
  $status = $stmt->execute();
  if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    // 登録に成功したらそのままログインしてsessionをセット ----------------------
    $sql = 'SELECT * FROM users_table WHERE email=:email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $status = $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    session_start();
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['user_id'] = $result['user_id']; //sessionにこれ入れることで、どこからでも使えるように。
  }
  // header('Location:../parent/parent_page.php');
  header('Location:../log/parent_login.php');
  exit();
}
