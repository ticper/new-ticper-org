<?php
  // セッションを開始
  session_start();
    if(isset($_SESSION['O_UserID']) == '') {
        print("<script>location.href = 'index.php';</script>");
        exit();
    }

  // セッション変数「UserID」にログイン中のユーザ名がないとき、ログイン画面に戻す。
  if(isset($_SESSION['O_UserID']) == '') {
    print("<script>location.href = 'index.php';</script>");
    exit();
  }
  $orgid = $_POST['orgid'];
  $change = $_POST['statuschangeto'];

  require_once('config/config.php');

    $orgid = $db_link -> real_escape_string($orgid);
    $change = $db_link -> real_escape_string($change);

  $sql = mysqli_query($db_link, "UPDATE tp_org SET Status = '$change' WHERE OrgID = '$orgid'");

  print('<script>alert("混雑度を変更しました。"); location.href = "o-changestatus.php"; </script>');
?>