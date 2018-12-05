<?php

  session_start();
  if(isset($_SESSION['O_UserID']) == '') {
    print("<script>location.href = 'index.php';</script>");
    exit();
  }
  // コンフィグを導入
  require_once('config/config.php');

  // index.php から投げた内容をローカル変数に入れる
  $foodid = $_POST['FoodID'];
  $maisu = $_POST['maisu'];

  // SQ+の特殊な文字を抜き取る
  $e_foodid = $db_link -> real_escape_string($foodid);
  $e_maisu = $db_link -> real_escape_string($maisu);

  // SQL文をデータベース鯖に投げる
  $sql = mysqli_query($db_link, "UPDATE tp_food SET cooked = cooked + '$e_maisu' WHERE FoodID = '$foodid'");

  print("<script>alert('更新しました');location.href = 'cook.php';</script>");
?>
