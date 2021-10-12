<?php

session_start();
include("../functions.php");
include("../config.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$parent_id = $_SESSION['parent_id'];
$task_id = $_POST['task_id'];


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/animejs.css">
  <style>
  
  body{
      background-color: #FFE382;
      height: 667px;
    }
    div{
      height: 50px;
      width: 50px;
    }

.green{
  background-color: greenyellow;
}
.red{
  background-color: red;
}
.blue{
  background-color: blue;
}

  </style>
</head>
<body>
  
<!-- <a href="../goal/goal_create.php">たっせい画面へ遷移</a> -->
<!-- ↑goal_create.phpを経由して表示画面のgoal_list.phpへ -->

<a href="child_goal.php">たっせい画面へ遷移</a> 

<div class="green"></div>
  <div class="red"></div>
  <div class="blue"></div>


<div id="translatexy"><img src="../images/istockphoto-1125716911-170667a.jpg" alt="" width="210px"></div>

<script src="../js/anime.min.js" ></script>
<script>
var test1 = anime({
  targets: ['.green', '.red', '.blue'],
  translateX: '13.5rem',
  scale: [.75, .9],
  delay: function(el, index) {
    return index * 80;
  },
  direction: 'alternate',
  loop: true
});


var test6 = anime({
  targets: '#translatexy',
  scale: {
    value: 2,
    delay: 200,
    duration: 1000,
    easing: 'easeInOutBounce',
  },
  loop: true
 });

 setTimeout(function(){
  window.location.href = 'child_goal.php';
}, 6*1000);
</script>
</body>
</html>