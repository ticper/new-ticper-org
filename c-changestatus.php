<?php
    // 交換番号を取得する
    $ChangeNo = $_GET['id'];
    
    require_once('config/config.php');
    $sql = mysqli_query($db_link, "SELECT Used, Changed FROM tp_ticket WHERE ChangeNo = '$ChangeNo'");
    $result = mysqli_fetch_assoc($sql);
    if($result['Used'] == 1 and $result['Changed'] == 0) {
        $sql = mysqli_query($db_link, "UPDATE tp_ticket SET Changed = 1 WHERE ChangeNo = '$ChangeNo'");
        header('Location: changelist.php');
        exit();
    }
?>
    
    