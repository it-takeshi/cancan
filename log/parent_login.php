<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/login.css">
  <title>保護者ログイン</title>
</head>
    <body class="">
    <header>
        <p><a href="#">Can × Can</a></p>
    </header>
        <section class="login"> 
            <h1>保護者 ログイン</h1>
            <p>下記内容の記入をお願いします。</p>
            <form action="parent_login_act.php" method="POST">
                <p>
                  <label>メールアドレス：
                        <input type="text" name="email">
                  </label>
                </p>
                <p>
                  <label>パスワード：
                        <input type="password" name="password">
                  </label>
                </p>
                <p>
                  <input type="submit" value="ログイン">
                </p>
              </form>
          </section>
          <div class="goto_home">
                  <a class="button" href="../home.php">ホーム画面へ</a>
          </div>
          <footer>© Can & Can</footer>
</body>

</html>