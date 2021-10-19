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
  <link rel="stylesheet" href="">  
  <style>
  body{
      background-color: #FFE382;
      height: 667px;
    }


/* ■head slide */
.head_slide{
	width: 100%;	
}
.head_slide_title{
	font-size: 46px; 	color: white;
	position: absolute;
	top:10px;
	right: 360px;
}
.head_slide_subtitle1{
	font-size: 36px;	color: white;
	position: absolute;
	top:170px;
	right: 530px;
}
.head_slide_subtitle2{
	font-size: 36px;	color: white;
	position: absolute;
	top:250px;
	right: 420px;
}

.head_slide_image{
width: 100%;
	height: 300px; 
	position: relative;
	background: url(../images/cracker_brwon.jpg);
	background-size: auto 100%;
	animation: bg-slider 23s linear infinite; 
	
}
@keyframes bg-slider {
	from { background-position: 0 0; }
    to { background-position: -1518px 0; } 
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

<!-- <a href="child_goal.php">たっせい画面へ遷移</a>  -->

<!-- ■head_slide -->
<section class="head_slide">
    <div class="head_slide_image"></div>
</section>
<!-- 
<div class="green"></div>
  <div class="red"></div>
  <div class="blue"></div> -->


<div id="translatexy"><img src="../images/cracker_red.jpg" alt="" width="210px"></div>

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
}, 4*1000);
</script>
</body>
</html>