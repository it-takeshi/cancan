<?PHP
session_start();
include("../functions.php");
check_session_id();
$pdo = connect_to_db();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>もの ことフォロー入力 </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="../css/things_input.css">
</head>

<body class="">

<header>
    <p><a href="index.html">Can × Can</a></p>
</header>
<section>
    <form action="things_check.php" method="post"  enctype="multipart/form-data">
        <p>
        <label>
        ものごと タイトル：
        <input type="text" name="things_name" placeholder="（例：バスののりかた）">
        </label>
        </p>

        <p>
        <label for="">メモ（説明や補足）:
            <textarea name="textarea" id="" rows="4" cols="37" placeholder="説明を入力（例：のるときに、ニモカカードを、きかいにかざす）"></textarea>
        </label>
        </p>

        <p>
        <label class="upload-label"> がぞう：
        <input type="file" name="upfile" accept="image/*" >
        <!-- capture="camera"  -->
        </label>
        </p>
        
        <p>
        <label class="upload-label"> どうが：
        <input type="file" name="upvideo" accept="video/*">
        <!-- <input type="file" name="upvideo" accept="image/*; capture=camera, video/*; capture=camera"> -->
        </label>
        </p>

        <p>
        <input type="submit" value="とうろく">
        </p>
    </form>
    </section>

    <div>
      <p> 
        <a href="../parent/parent_page.php">もどる</a>
      </p>
    </div>

    <footer>© Can & Can</footer>
    

        <!-- JavaScript -->
        <!-- リアルタイムではjquery-3.6.0.min.jsなので変更する -->
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
            $('#selectColor').bind('change', function(){
                $(this).removeClass();
                $(this).addClass('form-select').addClass($(this).val());
            });
        });
    </script>
    </body>
    </html>