<?php
session_start();
include("../functions.php");
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
    // $output .= "<td><img src='{$completed_task[$i]["image"]}' height='200px' ></td>";
    // $output .= "<td><img src='{$completed_task[$i]["image"]}' height='200px' ></td>";
    $output .= "<td><img src='../images/smiley-1635449__340.webp' height='10px'></td>";
    $output .= "</tr>";
  }

  $point = '';
    
  $point .=  count($completed_task);
  // var_dump($point);
  // exit();
  // $parent_checked_task_output .= "<td>{$parent_checked_task[$i]["task_name"]}</td>";
// var_dump($total);
// exit();

?>

<!DOCTYPE html>
<html lang="ja" class="h-100">
<head>
     <!-- Stylesheets -->
  
    <link rel="stylesheet" href="../css/all.min.css">
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <link rel="stylesheet" href="../css/animejs.css">   
<link rel="stylesheet" href="../css/child_goal.css">  

<!-- ↑順番で処理がされる。なので同じ部分を処理したときは最後のcss/style.cssが処理され、その内容が反映 -->
<style>
</style>
</head>

<body>
      <header>
        <ul>
          <li>  
            <button onclick="changePoint()" class="c-button" id="click_btn">たっせいを<br>チェック </button>
          </li>
          <audio id="click_sound" preload="auto">
            <source src="../audio/click24.mp3"  type="audio/mp3">
          </audio>
      
          <li> 
            <div id="outPoint"><?= $point ?>ポイント！!</div>
          </li>
          <li> 
            <a href="child_page.php?ymd='.date('Y-m-d')">もどる</a>
          </li>
        </ul>
      </header>
      <section >
              <!-- <div class="output2"></div> -->
              <div class="output">
                            <?= $output ?>
              </div>
      </section> 
</body>

<!-- java script! -->

  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/anime.min.js" ></script>
  <script>

window.onload = () => {
        const se     = document.querySelector('#click_sound');
        document.querySelector("#click_btn").addEventListener("click", () => {
            se.play();
        });
    };


$('#click_btn').click(function(){
$('#outPoint').show();
});
  

    var test1 = anime({
      targets: ['.output'],
      translateY: '54rem',
      // scale: [.75, .9],
      delay: function(el, index) {
        return index * 80;
      },
      direction: 'alternate',
      loop: true
    });


    var test2 =  anime({
  targets:  ['.output2'],
  width: '100%', // -> from '28px' to '100%',
  easing: 'easeInOutQuad',
  direction: 'alternate',
  loop: true
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