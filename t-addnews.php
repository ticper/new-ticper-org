<?php
    if(isset($_SESSION['O_UserID']) == '') {
        print("<script>location.href = 'index.php';</script>");
        exit();
    }
    session_start();
    $orgid = $_SESSION['OrgID'];
    $News = $_POST['news'];
    require_once('config/config.php');
    $News = $db_link -> real_escape_string($News);
    $News = htmlspecialchars($News, ENT_QUOTES);
    $sql = mysqli_query($db_link, "SELECT MAX(NewsID) AS num FROM tp_news");
    $result = mysqli_fetch_assoc($sql);
    $newsid = $result['num'] + 1;
    $sql = mysqli_query($db_link, "INSERT INTO tp_news VALUES ('$newsid', '$orgid', '$News')");
    header('Location: t-news.php');
    exit();

?>