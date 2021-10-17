<?php
//  var_dump($_POST);
// exit();
// array(2) { ["my_name"]=> string(15) "ジュリアン" ["parent_name"]=> string(9) "ジョン" }

session_start();

$_SESSION['session_id'];
// echo $_SESSION['session_id'];
// exit();

include("../functions.php");
include("../config.php");

check_session_id();
$pdo = connect_to_db();

$my_name = $_POST["my_name"];
$parent_name = $_POST["parent_name"];

$sql = 'SELECT * FROM users_table WHERE name=:name';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $my_name, PDO::PARAM_STR);
// ↑$my_name = $_POST["my_name"];なので$my_name は子供の名前。つまり':name'は子供の名前が入る
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $child_data = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($child_data);
  // exit(); OK
  // array(7) { ["user_id"]=> string(2) "19" ["name"]=> string(15) "ジュリアン" ["email"]=> NULL ["password"]=> NULL ["category"]=> string(5) "child" ["created_at"]=> string(10) "2021-09-27" ["updated_at"]=> string(10) "2021-09-27" }

  if (!$child_data) {
    echo "<p>あなたのおなまえは、あっていますか？</p>";
    echo '<div><a href="child_login.php">もういちど、やってみよう</a></div>';
    exit();
  } else {
    $sql = 'SELECT * FROM users_table WHERE name=:name';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $parent_name, PDO::PARAM_STR);
            // ↑今度は':name'は$parent_nameが入り、SELECT文で親の名前を照会
    $status = $stmt->execute();
    if ($status == false) {
      $error = $stmt->errorInfo();
      echo json_encode(["error_msg" => "{$error[2]}"]);
      exit();
    } else {
      $parent_data = $stmt->fetch(PDO::FETCH_ASSOC);
      // var_dump($parent_data);
      // exit(); OK
      // array(7) { ["user_id"]=> string(2) "18" ["name"]=> string(9) "ジョン" ["email"]=> string(4) "john" ["password"]=> string(8) "johnjohn" ["category"]=> string(6) "parent" ["created_at"]=> string(10) "2021-09-27" ["updated_at"]=> string(10) "2021-09-27" }

      if (!$parent_data) {
        echo "<p>おとうさんのおなまえは、あっていますか？</p>";
        echo '<div><a href="child_login.php">もういちど、やってみよう</a></div>';
        exit();
      } else {
        $sql = 'SELECT * FROM relation_table WHERE parent_id=:parent_id AND child_id=:child_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':parent_id', $parent_data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':child_id', $child_data['user_id'],  PDO::PARAM_INT);
        $status = $stmt->execute();
        if ($status == false) {
          $error = $stmt->errorInfo();
          echo json_encode(["error_msg" => "{$error[2]}"]);
          exit();
        } else {
          $val = $stmt->fetch(PDO::FETCH_ASSOC);
          // var_dump($val);
          // exit(); OK
          // array(5) { ["relation_id"]=> string(1) "6" ["parent_id"]=> string(2) "18" ["child_id"]=> string(2) "19" ["created_at"]=> string(10) "2021-09-27" ["updated_at"]=> string(10) "2021-09-27" }

          if (!$val) {
            echo "<p>おなまえは、あっていますか？</p>";
            echo '<div><a href="child_login.php">もういちど、やってみよう</a></div>';
            exit();
          } else {
            $_SESSION = array();
            $_SESSION['session_id'] = session_id();
            $_SESSION['user_id'] = $child_data['user_id'];
            $_SESSION['child_name'] = $child_data['name'];
                                  // $child_dataはusers_tableのその子の情報が配列で格納。
                            // なので$child_data['user_id']とはその子のusers_tableのuser_id（番号）を取っている
                            // なので$child_data['name']とはその子のusers_tableのname（名前）を取っている
            $_SESSION['parent_id'] = $parent_data['user_id'];
                                 // ↑上の子供の値の取り方と同じ。親のusers_tableのuser_id（番号）を取っている

              header('Location:../child/child_page.php?ymd=');

            // header('Location:../child_page.php?ymd='.date('Y-m-d', strtotime($start_datetime)));
            // ↑http://localhost/support_growth/child_page.php?ymd=1970-01-01となり、ブラウザnot found表示
           
          }
        }
      }
    }
  }
}
