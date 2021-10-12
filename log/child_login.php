<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>お子様ログイン</title>
<meta name="viewport" content="width=device-width">

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<link rel="stylesheet" href="../css/login.css">
 
</head>

<body class="">

<header><a href="index.html">Can × Can</a></header>

<nav>
    <ul>
    <li><a href="#">トップ</a></li>
    <li><a href="#">サイトについて</a></li>
    <li><a href="#">お問い合わせ</a></li>
    </ul>
</nav>


<section class="login"> 

<h2>お子様ログイン</h2>

<p>空らんに記入をお願いします。</p>


  <form action="child_login_act.php" method="POST">

  <h3>さあ、はじめよう！</h3>

  <p>
<label>
あなたのおなまえ：
<input type="text" name="my_name">
</label>
</p>

<p>
<label>
お父さんまたはお母さんのおなまえ：
<input type="text" name="parent_name">
</label>
</p>

<p><input type="submit" value="スタート"></p>
</form>
</section>

<div class="goto_home">
            <a class="button" href="../home.php">ホーム画面へ</a>
      </div>

    
    <footer>© Can & Can</footer>
</body>

</html>