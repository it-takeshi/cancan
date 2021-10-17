<?php
//  var_dump($_GET);
//  exit();

session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$parent_id = $_SESSION['parent_id'];
$start_datetime = $_POST['start_datetime'];

// 存在・形式チェック
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location:child_page.php');
    exit();
}

$sql = 'DELETE FROM new_task_table WHERE task_id = :task_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':task_id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();

// // 前の画面に移動
// header('Location:' . $_SERVER['HTTP_REFERER']);
// exit();

// // 画像の削除
// $sql = 'DELETE FROM images WHERE image_id = :image_id';
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':image_id', (int)$_GET['id'], PDO::PARAM_INT);
// $stmt->execute();

header('Location:child_page.php');
exit();

// // 予定詳細画面に遷移
// header('Location:child_page.php?ymd='.date('Y-m-d'));
// exit();
?>