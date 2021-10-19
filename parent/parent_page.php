<?php
session_start();
include("../functions.php");

check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$child_id = $_SESSION['child_id'];
$start_datetime = $_POST['start_datetime'];
$nocompleted_task_status = "0";
$completed_task_status = "1";

$sql = 'SELECT * FROM users_table WHERE user_id=:user_id ';
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

      $start_time = date('m-d H:i', strtotime($completed_task[$i]["start_datetime"]));

      $completed_task_output .= "<tr>";
      $completed_task_output .= "<td>{$start_time}</td>";
      $completed_task_output .= "<td>{$completed_task[$i]["task_name"]}</td>";
      $completed_task_output .= "<td><img src='{$completed_task[$i]["image"]}' width='30px'></td>";
      $completed_task_output .= "<td>
        <form action='task_response.php' method='POST'>
          <input type='hidden'  name='task_id' value={$completed_task[$i]["task_id"]}>
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

      $start_time_two = date('m-d H:i', strtotime($nocompleted_task[$i]["start_datetime"]));

      $nocompleted_task_output .= "<tr>";
      $nocompleted_task_output .= "<td>{$start_time_two}</td>";
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
  <!-- Stylesheets -->
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="../css/parent_page.css">
</head>

<body>
      <section class="button">
            <h3>
                <?= $user_data['name'] ?>さんのマイページ
            </h3>
          <nav>
            <ul>
              <!-- <li>  <a href="../account_create/child_create.php">お子さん新規登録</a></li> -->
              <!-- ↑手順は新規登録の時こどもの登録も終了してないとセッション繋がらないのでここは使わないようにする -->
              <!-- <li> <a href="parent_task_input.php">タスクを登録</a></li> -->
              <li> <a href="../template/template_list.php">タスク</a></li> 
              <li> <a href="../things/things_list.php">もの・こと</a></li>
            </ul>
            </nav>
            <p>
              <input type="button" value="おわったのないかな？" onclick="koshin()">
            </p>
      </section>
      <section class="completed_task_output">
              <p>完了した予定</p>
              <audio id="click_sound" preload="auto">
                              <source src="../audio/click3.mp3"  type="audio/mp3">
                        </audio>
                    <table>
                      <tr>
                      <td> <?= $completed_task_output ?></td>
                      </tr>
                    </table> 
          </section>
          <section class="nocompleted_task_output">

              <p>未完了の予定</p>
                  <table>
                      <tr>
                      <td> <?= $nocompleted_task_output ?></td>
                      </tr>
                    </table> 
            </section>

            <div class="logout">
              <a href="../log/logout.php">ログアウト</a>
            </div>

  <footer class="footer py-3 mt-auto bg-light">
    <div class="container text-center">
        <span class="text-muted">&copy; Can Can</span>
    </div>
    <div class="container text-center">
        <span class="text-muted">&copy; Can Can</span>
    </div>
    <div class="container text-center">
        <span class="text-muted">&copy; Can Can</span>
    </div>
</footer>

<script>
    function koshin() {
      location.reload();
    }

    window.onload = () => {
        const se     = document.querySelector('#click_sound');
        document.querySelector("#response_btn").addEventListener("click", () => {
            se.play();
        });
    };
</script>
</body>
</html>
