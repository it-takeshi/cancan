<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<link rel="stylesheet" href="../css/login.css">
  <title>保護者ログイン</title>
</head>
    <body class="">
    <header>
      <div class="img_title">
    <img src="../images/dog1.jpg" alt="" width="50px" height="50px">Can × Can
    </div>
    </header>
  
    <section class="login"> 
            <h2>保護者 ログイン</h2>
            <p>下記内容の記入をお願いします。</p>
            <form action="parent_login_act.php" method="POST">
                <p>
                  <label>メールアドレス：
                        <input type="text" name="email" autocomplete="off">
                  </label>
                </p>
                <p>
                  <label>パスワード：
                        <input type="password" name="password" autocomplete="new-password">
                  </label>
                </p>
                <p>
                  <input type="submit" value="ログイン">
                </p>
              </form>
          </section>
</body>

</html>