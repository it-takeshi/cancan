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
<title>テンプレート入力 </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="../css/template_input.css">
</head>

<body class="">

<header>
        <a href="index.html">Can × Can</a>
  </header>


<section>
    
    <form action="template_check.php" method="post"  enctype="multipart/form-data">

        <p>
        <label>
        やることテンプレート：
        <input type="text" name="template_name" placeholder="テンプレート名を入力（例：電車に乗る）">
        </label>
        </p>
        <p>
        <label class="upload-label"> がぞう：
        <input type="file" name="upfile" accept="image/*"capture="camera"> 
        </label>
        </p>
        <p>
        <p>
        <input type="submit" value="とうろく">
        </p>
    </form>
    </section>

    <div>
        <ul>
            <li>  <a href="template_list.php">テンプレ一覧</a></li>
            <li> <a href="../parent/parent_page.php">マイページへ</a></li>
        </ul>
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