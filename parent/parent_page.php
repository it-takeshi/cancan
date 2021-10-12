<?php
session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$child_id = $_SESSION['child_id'];
$start_datetime = $_POST['start_datetime'];
$nocompleted_task_status = "0";
$completed_task_status = "1";


$sql = 'SELECT * FROM users_table WHERE user_id=:user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
  
}

$sql = 'SELECT * FROM new_task_table WHERE child_id=:child_id AND parent_id=:parent_id AND task_status=:task_status ORDER BY start_datetime ASC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $child_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':task_status', $completed_task_status, PDO::PARAM_STR);
//                                ↑$completed_task_status = "1" 子供が完了したタスクを取ってくる;
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $completed_task = $stmt->fetchALL(PDO::FETCH_ASSOC);
  if ($completed_task) {
    // ↓下記task_idのセッションを追加
    // $_SESSION = array();
    // $_SESSION['task_id'] = $completed_task['task_id'];

    $completed_task_output = "<tr><td>いつから</td><td>すること</td><td class='image'></td><td>確認</td></tr>";
    for ($i = 0; $i < count($completed_task); $i++) {
      $completed_task_output .= "<tr>";
      $completed_task_output .= "<td>{$completed_task[$i]["start_datetime"]}</td>";
      $completed_task_output .= "<td>{$completed_task[$i]["task_name"]}</td>";
      $completed_task_output .= "<td><img src='{$completed_task[$i]["image"]}' width='30px'></td>";
      $completed_task_output .= "<td>
        <form action='task_response.php' method='POST'>
          <input type='hidden' name='task_id' value={$completed_task[$i]["task_id"]}>
          <button id='response_btn' type='submit'>OK</button>
        </form>
    </td>";
      $completed_task_output .= "</tr>";
    }
  } else {
    $completed_task_output = "<tr><td class='image'></td><td>今はありません</td><td></td><td></td><td></td></tr>";
  }
}

$sql = 'SELECT * FROM new_task_table WHERE child_id=:child_id AND parent_id=:parent_id AND task_status=:task_status ORDER BY start_datetime ASC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $child_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':task_status', $nocompleted_task_status, PDO::PARAM_STR);
                                  // $nocompleted_task_status = "0" ←まだ完了のタスク;
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $nocompleted_task = $stmt->fetchALL(PDO::FETCH_ASSOC);
  if ($nocompleted_task) {
    $nocompleted_task_output = "<tr><td>いつから</td><td>すること</td><td class='image'></td></tr>";
    for ($i = 0; $i < count($nocompleted_task); $i++) {
      $nocompleted_task_output .= "<tr>";
      $nocompleted_task_output .= "<td>{$nocompleted_task[$i]["start_datetime"]}</td>";
      $nocompleted_task_output .= "<td>{$nocompleted_task[$i]["task_name"]}</td>";
      $nocompleted_task_output .= "<td><img src='{$nocompleted_task[$i]["image"]}' width='20px'></td>";
      $nocompleted_task_output .= "</tr>";
    }
  } else {
    $nocompleted_task_output = "<tr><td class='image'></td><td>今はありません</td><td></td><td></td><td></td></tr>";
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>大人のマイページ</title>
<meta name="viewport" content="width=device-width">
<!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous"> 
<link rel="stylesheet" href="../css/parent_page.css">
</head>

<body class="parent_page">
   <!-- cssでbodyにdisplay:grid;設定をするとbodyタグの1階層下の大枠タグ <></>が -->
<!-- グリッドに配置するパーツと認識される -->

<!-- パーツ[head] -->
      <header>
          <a href="index.html">Can×Can</a>
      </header>

      <nav>
          <ul>
          <li><a href="index.html">トップ</a></li>
          <li><a href="about.html">サイトについて</a></li>
          <li><a href="contact.html">お問い合わせ</a></li>
          </ul>
      </nav>
<!-- パーツ[head] --> 

<!-- パーツ[button] -->
      <section class="button">
            <h3>
                <?= $user_data['name'] ?>さんのマイページ
            </h3>
            <ul>
              <li>  <a href="../account_create/child_create.php">お子さんの新規登録</a></li>
              <li> <a href="parent_task_input.php">お子さんの予定を登録</a></li>
              <li> <a href="../log/logout.php">ログアウト</a></li>
            </ul>
            <p>
              <input type="button" value="おわったのないかな？" onclick="koshin()">
            </p>
      </section>
 <!-- パーツ[button] -->

 <!-- パーツ[completed_task_output] -->
        <section class="completed_task_output">
              <p>完了した予定</p>
                    <table>
                      <tr>
                      <td> <?= $completed_task_output ?></td>
                      </tr>
                    </table> 
              <!-- <div><?= $completed_task_output ?></div> -->
          </section>
<!-- パーツ[completed_task_output] -->

<!-- パーツ[nocompleted_task_output] -->
          <section class="nocompleted_task_output">
              <p>未完了の予定</p>
            <!-- <div><?= $nocompleted_task_output ?></div> -->
                  <table>
                      <tr>
                      <td> <?= $nocompleted_task_output ?></td>
                      </tr>
                    </table> 
            </section>
<!-- パーツ[nocompleted_task_output] -->

<!-- パーツ[foot]  -->
          <footer>© Can & Can</footer>
<!-- パーツ[foot]  -->

<script>
    function koshin() {
      location.reload();
    }
</script>
</body>
</html>
