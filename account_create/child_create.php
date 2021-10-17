<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>お子様用アカウント作成</title>

<meta name="viewport" content="width=device-width">

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<link rel="stylesheet" href="../css/account_create.css">
</head>

<body class="">

	<header>
		<a href="index.html">Can × Can</a>
	</header>

	<nav>
		<ul>
		<li><a href="index.html">トップ</a></li>
		<li><a href="about.html">サイトについて</a></li>
		<li><a href="contact.html">お問い合わせ</a></li>
		</ul>
	</nav>

      <section>

            <h1>お子様を新規登録</h1>

            <p>下記内容の記入をお願いします。</p>

            <form action="child_create_act.php" method="POST" class="new_account_form">
                  <p>
                  <label>
                  お名前：
                  <input type="text" name="name">
                  </label>
                  </p>
                  <p><input type="submit" value="登録"></p>
            </form>

      </section>

      <div class="">
            <a class="button" href="../parent/parent_page.php">マイページ画面へ</a>
      </div>

      <footer>© Can & Can</footer>

</body>
</html>
