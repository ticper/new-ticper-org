<?php
    session_start();
    $orgid = $_SESSION['OrgID'];
    $News = $_POST['news'];
    require_once('config/config.php');
    $sql = mysqli_query($db_link, "SELECT MAX(NewsID) AS num FROM tp_news");
    $result = mysqli_fetch_assoc($sql);
    $newsid = $result['num'] + 1;
    $sql = mysqli_query($db_link, "INSERT INTO tp_news VALUES ('$newsid', '$orgid', '$News')");
    header('Location: t-news.php');
    exit();

?>