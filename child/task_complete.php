<?php
//  var_dump($_POST);
// exit();
// array(1) { ["task_id"]=> string(1) "1" } OK

session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$parent_id = $_SESSION['parent_id'];
$task_id = $_POST['task_id'];
$goal_image = $_POST['filename_to_save3'];

$task_status = "1";
                                                                                  // ↓child_idカラムに
                                                                                  // :user_idの値が入る
$sql = 'UPDATE new_task_table SET task_status=:task_status WHERE task_id=:task_id AND child_id=:user_id AND parent_id=:parent_id';
                           // ↑SET  $task_status = "1";をセット 
                          //  どれWHERE？ child_page.phpから送信がきた 所定のtask_id,user_id,parent_idに対して
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':task_status', $task_status, PDO::PARAM_STR);
$stmt->bindValue(':task_id', $task_id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}else{
  header('Location:child_cel.php');
  exit();
  // 登録に成功したら、そのデータを取得する --------------------------------------------------
  // $sql = 'SELECT * FROM new_task_table WHERE task_status=:task_status';
  // $stmt = $pdo->prepare($sql);
  // $stmt->bindValue(':task_status', $task_status, PDO::PARAM_STR);
  // $status = $stmt->execute();
  // $own = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($own); 
  // exit(); 下記のデータが取れる。
  // array(7) { ["user_id"]=> string(2) "14" ["name"]=> string(9) "なつき" ["email"]=> NULL ["password"]=> NULL ["category"]=> string(5) "child" ["created_at"]=> string(10) "2021-09-27" ["updated_at"]=> string(10) "2021-09-27" }
  //  // 下記を追加
  //  session_start();
  //  $_SESSION = array();
  //  $_SESSION['session_id'] = session_id();
  //  $_SESSION['task_id'] = $own['task_id']; //sessionにこれ入れることで、どこからでも使えるように。

  // if ($status == false) {
  //   $error = $stmt->errorInfo();
  //   echo json_encode(["error_msg" => "{$error[2]}"]);
  //   exit();
  // } else {
    // //  -----$goal_image = $_POST['filename_to_save3'];の値が受け取れない。一旦コメントアウト
    // $sql =  'INSERT INTO goal_table (goal_id, task_id, child_id, parent_id, image, task_status, created_at, updated_at) VALUES (NULL, :task_id,:child_id,:parent_id, :image, :task_status, sysdate(), sysdate())';

    //     $stmt = $pdo->prepare($sql);
    //     $stmt->bindValue(':task_id', $task_id, PDO::PARAM_INT);
    //     $stmt->bindValue(':child_id', $user_id, PDO::PARAM_INT);
    //     $stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
    //     $stmt->bindValue(':image', $goal_image, PDO::PARAM_STR);
    //     $stmt->bindValue(':task_status', $completed_task_status, PDO::PARAM_STR);
    // $status = $stmt->execute();

    // if ($status == false) {
    //   $error = $stmt->errorInfo();
    //   echo json_encode(["error_msg" => "{$error[2]}"]);
    //   exit();
    // }
  }
 

  






