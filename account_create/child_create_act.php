<?php
session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
// var_dump($user_id); 
// exit();

$name = $_POST['name'];
$category = "child";

// 子供の名前が既に使われていないかテェック ------------------------------------------------
$sql = 'SELECT * FROM users_table WHERE name=:name';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$status = $stmt->execute();
$val = $stmt->fetch(PDO::FETCH_ASSOC);
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  if ($val) {
    echo "<p>お名前は既に使用されています</p>";
    echo '<a href="child_create.php">別のお名前で登録</a>';
    exit();
  } else {
    // 使われていないお名前であれば、users_table に 子供として DATAセット ------------------------------------------------
    $sql =  'INSERT INTO users_table (user_id, name, email, password, category, created_at, updated_at) VALUES (NULL, :name, NULL, NULL, :category, sysdate(), sysdate())';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':category', $category, PDO::PARAM_STR);
    $status = $stmt->execute();
    if ($status == false) {
      $error = $stmt->errorInfo();
      echo json_encode(["error_msg" => "{$error[2]}"]);
      exit();
    } else {
      // 登録に成功したら、そのデータを取得する --------------------------------------------------
      $sql = 'SELECT * FROM users_table WHERE name=:name';
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $status = $stmt->execute();
      $own = $stmt->fetch(PDO::FETCH_ASSOC);
      // var_dump($own); 
      // exit(); 
      // 下記のデータが取れる。
      // array(7) { ["user_id"]=> string(2) "14" ["name"]=> string(9) "なつき" ["email"]=> NULL ["password"]=> NULL ["category"]=> string(5) "child" ["created_at"]=> string(10) "2021-09-27" ["updated_at"]=> string(10) "2021-09-27" }
       // 下記を追加
       session_start();
       $_SESSION = array();
       $_SESSION['session_id'] = session_id();
       $_SESSION['child_id'] = $own['user_id']; //sessionにこれ入れることで、どこからでも使えるように。

      if ($status == false) {
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
      } else {
        // 取得に成功したら、その親の user_id と 子供の user_id を relation_table に登録し関連付ける --------------------------------------------------
        $sql =  'INSERT INTO relation_table (relation_id, parent_id, child_id, created_at, updated_at) VALUES (NULL, :parent_id, :child_id, sysdate(), sysdate())';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':parent_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':child_id', $own['user_id'],  PDO::PARAM_INT);
        $status = $stmt->execute();
    
        if ($status == false) {
          $error = $stmt->errorInfo();
          echo json_encode(["error_msg" => "{$error[2]}"]);
          exit();
        }
      }
    }
  }
}
header('Location:../log/parent_login.php');
// header('Location:../parent/parent_page.php');
exit();
