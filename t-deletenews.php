<?php
    if(isset($_SESSION['O_UserID']) == '') {
        print("<script>location.href = 'index.php';</script>");
        exit();
    }
    $id = $_GET['id'];
    require_once('config/config.php');
    $id = $db_link -> real_escape_string($id);
    $sql = mysqli_query($db_link, "DELETE FROM tp_news WHERE NewsID = '$id'");
    header('Location: t-news.php');
    exit();
?>