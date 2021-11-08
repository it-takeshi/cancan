<?php
// var_dump($_POST);
//  exit();
// array(1) { ["template"]=> string(1) "8" }
// ↑template_list.phpの「テストをする」をクリック
// 設定はvalue={$templates[$i]["template_id"]}で。
// なのでこのファイルへは上記のid番号8をデータとして受け取ることができた
// このid番号8番のデータをtemplate_tableからひっぱってくる

session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];
$parent_id = $_SESSION['parent_id'];
$start_datetime = $_POST['start_datetime'];
$template_id = $_POST['template'];

// template_tableから選んだテンプレを取得
$sql = 'SELECT * FROM template_table WHERE template_id=:template_id';
$stmt = $pdo->prepare($sql);
                                                    // 注意↓idを取得するときはINT
$stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $template_data = $stmt->fetch(PDO::FETCH_ASSOC);
//   var_dump($template_data["template_name"]);
//   exit();表示はstring(15) "学校へ行く"
// var_dump($template_data["template_image"]);
// exit(); 表示は string(60) "../upload/202110121341380483840ae224e6d447771cd7a4f0d36e.png"
  
  //⭐️ $stmt->fetchで下記処理の場合
  // var_dump($template_data);
  //  exit();
  //  array(5) { 
    //        ["template_id"]=> string(1) "6" 
    //        ["template_name"]=> string(15) "バスにのる" 
    //         ["template_image"]=> string(60) "../upload/20210929150343baa3efa1ba321f792824f21bda7105dd.png"       ["created_at"]=> string(19) "2021-09-29 15:03:45" 
    //         ["updated_at"]=> string(19) "2021-09-29 15:03:45"
    //  }

  //⭐️ $stmt->fetchAllで下記処理の場合
    //var_dump($template_data);
    //exit();
        // array(1)
        //  { [0]=> 
        //     array(5)
        //      { ["template_id"]=> string(1) "5"
        //          ["template_name"]=> string(15) "電車にのる" 
        //          ["template_image"]=> string(60) "../upload/202109291442092407e0623e3ac662f41d62550f9a8707.png" ["created_at"]=> string(19) "2021-09-29 14:42:10" 
        //          ["updated_at"]=> string(19) "2021-09-29 14:42:10" } }

        // // $stmt->fetchと$stmt->fetchAllの違い  配列の階層が違う
}
    // $output = "";
    // for ($i = 0; $i < count($template_data); $i++) {
    //     // count()関数で$template_dataの配列の数を
    $output1 = "";
    for ($i = 0; $i < count($template_data); $i++) {
        // count()関数で$template_dataの配列の数を取る
            $output1 .= "<img src='{$template_data[$i]["template_image"]}' width='20px'>";
    }
    $output2 = "";
    for ($i = 0; $i < count($template_data); $i++) {
        // count()関数で$template_dataの配列の数を取る
        $output2 .= "<div>{$template_data[$i]["template_name"]}</div>";
    }

    ?>

<!DOCTYPE html>
<html lang="ja" class="h-100">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="../css/temple_check_create.css">
</head>

<body>
<header>
    <div class="img_title">
    <img src="../images/dog1.jpg" alt="" width="90px" height="90px">Can × Can
    </div>
    </header>

  <h2 class="title1">やることを作成してください</h2>
  
  <section class="check"> 
        <div>

          <p><?php echo $template_data["template_name"]; ?>のテンプレートを使用中</p>
        </div> 
        <div><a href="../template/template_list.php">変更する</a></div>
      <div class="check_img">  
            <img src='<?= $template_data['template_image'];?>' width='50px'>
      </div>
    
      </section>

  <h2 class="title2">はじめる日時と色を選択してください</h2>

  <section class="submit">  
      <form action="parent_task_create.php" method="POST" enctype="multipart/form-data">

      <p>
      <label>
      いつから？：
      <input type="text" name="start_datetime" id="inputStartDateTime"
      placeholder="はじめる時間を入れよう。" autocomplete="off">
      </label>
      </p>

      <div class="mb-5">
          <label for="selectColor" class="form-label">カラー</label>
                        <select name="color" id="selectColor" class="form-select bg-light">
                            <option value="bg-light" selected>白</option>
                            <option value="bg-danger">赤</option>
                            <option value="bg-warning">オレンジ</option>
                            <option value="bg-primary">青</option>
                            <option value="bg-info">水色</option>
                            <option value="bg-success">緑</option>
                            <option value="bg-dark">黒</option>
                            <option value="bg-secondary">グレー</option>
                        </select>
          </div>

    <input type="hidden" name="filename_to_save" value="<?= $template_data['template_image'] ?>"> 

    <input type="hidden" name="task_name" value="<?= $template_data["template_name"] ?>"> 
    <div> <button type="submit" >とうろく</button></div>

 
  </form>
  </section>

   
 
</body>

        <!-- JavaScript -->
        <!-- リアルタイムではjquery-3.6.0.min.jsなので変更する -->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery-3.6.0.min.js"></script>
        <script src="../js/moment.min.js"></script>
        <script src="../js/ja.js"></script>
        <script src="../js/bootstrap-datetimepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />

        <script>

$(function() {
    $.datetimepicker.setLocale('ja');
  $('#inputStartDateTime').datetimepicker({
    
    allowTimes:[
    
    '06:00', '06:10', '06:20', '06:30', '06:40', '06:50', 
    '07:00', '07:10', '07:20', '07:30', '07:40', '07:50', 
    '08:00', '08:10', '08:20', '08:30', '08:40', '08:50', 
    '09:00', '09:10', '09:20', '09:30', '09:40', '09:50', 
    '10:00', '10:10', '10:20', '10:30', '10:40', '10:50', 
    '11:00', '11:10', '11:20', '11:30', '11:40', '11:50', 
    '12:00', '12:10', '12:20', '12:30', '12:40', '12:50', 
    '13:00', '13:10', '13:20', '13:30', '13:40', '13:50', 
    '14:00', '14:10', '14:20', '14:30', '14:40', '14:50', 
    '15:00', '15:10', '15:20', '15:30', '15:40', '15:50', 
    '16:00', '16:10', '16:20', '16:30', '16:40', '16:50', 
    '17:00', '17:10', '17:20', '17:30', '17:40', '17:50', 
    '18:00', '18:10', '18:20', '18:30', '18:40', '18:50', 
    '19:00', '19:10', '19:20', '19:30', '19:40', '19:50', 
    '20:00', '20:10', '20:20', '20:30', '20:40', '20:50', 
    '21:00', '21:10', '21:20', '21:30', '21:40', '21:50', 
    '22:00', '22:10', '22:20', '22:30', '22:40', '22:50', 
    '23:00', '23:10', '23:20', '23:30', '23:40', '23:50',

    ]
    
  });
});
    //         $(function () {
    //     $('#ymPicker').datetimepicker({
    //         format: 'YYYY-MM',
    //         locale: 'ja'
    //     });
    //     $('.task-datetime').datetimepicker({
    //     dayViewHeaderFormat: 'YYYY年 MMMM',
    //     format: 'YYYY/MM/DD HH:mm',
    //     locale: 'ja',
    //   });
    //   $('.search-date').datetimepicker({
    //     format: 'YYYY/MM/DD',
    //     locale: 'ja'
    //     });
    //   $('#selectColor').bind('change', function(){
    //     $(this).removeClass();
    //     $(this).addClass('form-select').addClass($(this).val());
    //   });
    // });
    </script>
    </body>
    </html>