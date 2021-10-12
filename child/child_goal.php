<?php

session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$parent_id = $_SESSION['parent_id'];
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
  //  var_dump($user_data);
  // exit();
  // array(7) { ["user_id"]=> string(2) "23" ["name"]=> string(9) "こども" ["email"]=> NULL ["password"]=> NULL ["category"]=> string(5) "child" ["created_at"]=> string(10) "2021-09-29" ["updated_at"]=> string(10) "2021-09-29" }
  
}

$sql = 'SELECT * FROM new_task_table WHERE child_id=:child_id AND parent_id=:parent_id AND task_status=:task_status ORDER BY start_datetime ASC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
$stmt->bindValue(':task_status', $completed_task_status, PDO::PARAM_STR);
//                                ↑$completed_task_status = "1" 子供が完了したタスクを取ってくる;
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $completed_task = $stmt->fetchALL(PDO::FETCH_ASSOC);
  //  var_dump($completed_task);
  //  exit();
  // array(1) 
  // { [0]=> array(10) { ["task_id"]=> string(2) "54" ["child_id"]=> string(2) "23" ["parent_id"]=> string(2) "22" ["task_name"]=> string(18) "買い物へ行く" ["start_datetime"]=> string(19) "2021-10-02 10:52:00" ["color"]=> string(10) "bg-success" ["image"]=> string(60) "../upload/202110030952343989f12a9a024d94fab4dd702772183e.png" ["task_status"]=> string(1) "1" ["created_at"]=> string(19) "2021-10-03 09:52:35" ["updated_at"]=> string(19) "2021-10-03 09:52:35" }  
}
$output = "";
$output = "<tr><td></td>{$completed_task[$i]}<td></td></tr>";
for ($i = 0; $i < count($completed_task); $i++) {
  // count()関数で$completed_taskの配列の数を取る
    $output .= "<tr>";
    $output .= "<td><img src='{$completed_task[$i]["image"]}' height='200px' ></td>";
    $output .= "<td><img src='{$completed_task[$i]["image"]}' height='200px' ></td>";
    
    $output .= "</tr>";
  }


?>


<!DOCTYPE html>
<html lang="ja" class="h-100">
<head>
     <!-- Stylesheets -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
<!-- ↑順番で処理がされる。なので同じ部分を処理したときは最後のcss/style.cssが処理され、その内容が反映 -->
<style>

  ul{
    list-style: none;
  }

  body{
      background-color: #FFE382;
      /* height: 667px; */
    }

     h2 a i{
       color: red;
     }

</style>
</head>


<main>
<div>○○ポイント</div>
<div>画像やデータを表示</div>
<h1><a href="child_page.php"><i class="fas fa-hand-paper"></i></a></h1>

<table>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
<!-- <ul><?= $output ?></ul> -->
<div>
  <!-- <ul id="result"></ul> -->
</div>
    
  </main> 
    <footer></footer>
<!-- java script! -->
<script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/ja.js"></script>
  <script src="../js/bootstrap-datetimepicker.min.js"></script>

  <script>


    $(function () {
        $('#ymPicker').datetimepicker({
            format: 'YYYY-MM',
            locale: 'ja'
        });
        $('.task-datetime').datetimepicker({
        dayViewHeaderFormat: 'YYYY年 MMMM',
        format: 'YYYY/MM/DD HH:mm',
        locale: 'ja',
      });
      $('.search-date').datetimepicker({
        format: 'YYYY/MM/DD',
        locale: 'ja'
        });
      $('#selectColor').bind('change', function(){
        $(this).removeClass();
        $(this).addClass('form-select').addClass($(this).val());
      });
    });
</script>

</body>

</html>
<!-- 
if ($completed_task) {
    // $completed_task_output = "<tr><td class='image'></td><td>いつから</td><td>すること</td><td>確認</td><td></td></tr>";
    $completed_task_output = '';
    for ($i = 0; $i < count($completed_task); $i++) {
       // json_encode関数でJSON形式のフォーマットに変換、そして変数「json_array_completed_task_output」にJSONデータを格納。
      // $json_array_completed_task_output = json_encode($completed_task[$i]['task_status']);
      // var_dump($json_array_completed_task_output);
      // exit(); 

        // $completed_task_output .= $completed_task[$i]["task_status"];

        
        $completed_task_output .=  "<div><img src='{$completed_task[$i]["image"]}' width='30px'></div>";
        // $completed_task_output .= $completed_task[$i]["image"];
        $json_array_completed_task_output = json_encode($completed_task_output);
  //      $completed_task_output .= "<tr>";
  //     //  $completed_task_output .= "<td>{$completed_task[$i]["task_status"]}</td>";
  //      $completed_task_output .= "<td>{$completed_task[$i]["task_status"]}</td>";
  // //     var_dump($completed_task_output);
  // // exit(); 数字1

      
  //      $completed_task_output .= "</tr>";
    }

  }  -->



  <!-- // JSデータ受け取り
// const completed_task_output = JSON.parse('<?php echo $json_array_completed_task_output; ?>');
// console.log(completed_task_output);

// let count ='';

// for(let i=0; i<completed_task_output.length;i++){
//   count = count +`${completed_task_output[i]}`;
// }
// console.log(count);
// $('#result').append(count);
// // $('#result').css('color','red') -->