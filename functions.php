<?php

// ユーザー名：b1d3de227d6eca
// パスワード：bc0de00a
// ホスト名：us-cdbr-east-04.cleardb.com
// データベース名：heroku_e72eea33a62837b




function connect_to_db()
{
                    
      $dbn = 'mysql:dbname=heroku_e72eea33a62837b;charset=utf8;port=3306;host=us-cdbr-east-04.cleardb.com';
      $user = 'b1d3de227d6eca';
      
      $pwd = 'bc0de00a';

      try {
        return new PDO($dbn, $user, $pwd);
      } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
      }
}



function check_session_id()
{
  if (
    !isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()
  ) {
    // header("Location:../log/login.php");
      header("Location:../home.php");

  } else {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
  }
}


