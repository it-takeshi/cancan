<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>新規登録</title>

<meta name="viewport" content="width=device-width">

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<link rel="stylesheet" href="../css/account_create.css">
</head>


<body class="">

	<header>
		<p>	<a href="#">Can × Can</a></p>
	</header>

	<nav>
		<ul>
		<li><a href="../home.php">トップ</a></li>
		<li><a href="../about.php">サイトについて</a></li>
		<li><a href="../contact.php">お問い合わせ</a></li>
		</ul>
	</nav>


	<section>
		<h1>保護者の方 新規登録</h1>

		<p>下記内容の記入をお願いします。</p>

			<form action="parent_create_act.php" method="POST" class="new_account_form">

					<p>
					<label>
					名前：
					<input type="text" name="name" autocomplete="name">
					</label>
					</p>

					<p>
					<label>
					メールアドレス：
					<input type="text" name="email">
					<!-- ↑typeをemailにするとバリデーション（エラーチェック）が利く
					@マーク等必須になる。NULLができない。今回はtypeはtextで --> 
					</label>
					</p>

					<p>
					<label>
					パスワード：
					<input type="password" name="password">
					</label>
					</p>

					<p>
						<input type="submit" value="登録">
					</p>
		</form>

	</section>

	<div class="goto_home">
      <a class="button" href="../home.php">ホーム画面へ</a>
  </div>

	<footer>© Can & Can</footer>

</body>
</html>
