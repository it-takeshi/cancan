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
          <h2><a href="index.html">Can × Can</a></h2>

          <nav class="navbar navbar-expand-md  navbar-light bg-light  fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Can × Can</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="add.php"><i class="fa fa-plus"></i> 追加</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php"><i class="fa fa-search"></i> 検索</a>
                    </li>
                </ul>
                <form class="d-flex" action="calendar.php">
                    <input type="text" name="ym" class="form-control me-2" placeholder="年月を選択" id="ymPicker">
                    <button class="btn btn-outline-dark text-nowrap" type="submit">表示</button>
                </form>
            </div>
        </div>
    </nav>

          </header>

        <!-- <nav>
            <ul>
              <li><a href="index.html">トップ</a></li>
              <li><a href="about.html">サイトについて</a></li>
              <li><a href="contact.html">お問い合わせ</a></li>
            </ul>
        </nav> -->

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