<?php

function connect_to_db()
{
                        //↓接続するDB名を入力 今回利用DBは「can_can」
      $dbn = 'mysql:dbname=can_can;charset=utf8;port=3306;host=localhost';
      $user = 'root';
      // ↓今回MAMPを利用している。$pwd = 'root';となる
      $pwd = 'root';

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


