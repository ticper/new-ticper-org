<?php
  session_start();
  if(isset($_SESSION['O_UserID']) == '') {
    print("<script>location.href = 'index.php';</script>");
  } else {

  }
?>
<!DOCTYPE HTML>
<html lang="ja">
  <head>
    <!-- エンコード設定 -->
    <meta charset="UTF-8" />

    <!-- 検索エンジンに掲載させない -->
    <meta name="robots" content="noindex,nofollow" />

    <!-- レスポンシブデザイン -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- ページタイトル -->
    <title>食券受付 - Ticper</title>

    <!-- jQuery(フレームワーク)導入 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Materialize(フレームワーク)導入 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Googleアナリティクス -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113412923-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-113412923-2');
    </script>
  </head>
  <body>
    <ul id="o-menu" class="dropdown-content">
      <li><a href="changelist.php">食券受付</a></li>
      <li><a href="s-check.php">食券情報表示</a></li>
    </ul>
    <ul id="slide-out" class="sidenav">
      <li>
        <div class="user-view">
          <div class="background">
            <img width="100%" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a1/Yamabuki_High_School.JPG/1200px-Yamabuki_High_School.JPG">
          </div>
          <a href="#!user"><img class="circle" src="img/icon.jpg"></a>
          <a href="#!name" style="color: white;">
            <?php
              $UserID = $_SESSION['O_UserID'];
              require_once('config/config.php');
              $sql = mysqli_query($db_link, "SELECT UserName, OrgID FROM tp_user_org WHERE UserID = '$UserID'");
              $result = mysqli_fetch_assoc($sql);
              print($result['UserName']);
              $OrgID = $result['OrgID'];
            ?>
          </a>
        </div>
      </li>
      <li><a href="#!" class="dropdown-trigger" data-target="o-menu">食券管理メニュー<i class="material-icons right">arrow_drop_down</i></a></li>
      <li class="divider"></li>
      <li><a href="o-changestatus.php">混雑度管理メニュー</a></li>
      <li class="divider"></li>
      <li><a href="cook.php">調理管理メニュー</a></li>
      <li class="divider"></li>
      <li><a href="logout.php">ログアウト</a></li>
    </ul>
    <nav class="light-blue darken-4">
      <div class="container">
        <div class="nav-wrapper">
          <a href="home.php" class="brand-logo">Ticper</a>
          <div class="right hide-on-med-and-down">
            <a href="#!" onClick="var elem = document.querySelector('.sidenav');var instance = M.Sidenav.getInstance(elem);instance.open();" class="btn">メニューを開く</a>
          </div>
          <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col s12">
              <br><br>
              <a href="qrcheck.php" class="btn"><font size="5"><b>食券を読み取る</b></font></a>
              <h2>待機中</h2>
              <table>
                <tr><th>受付番号</th><th>商品名</th><th>数量</th><th>ステータス変更</th></tr>
                <?php
                    $sql = mysqli_query($db_link, "SELECT * FROM tp_food WHERE OrgID = '$OrgID'");
                    while($result2 = mysqli_fetch_assoc($sql)) {
                        $FoodID = $result2['FoodID'];
                        $FoodName = $result2['FoodName'];
                        $sql2 = mysqli_query($db_link, "SELECT * FROM tp_ticket WHERE FoodID = '$FoodID' AND Used = '1' AND Changed = '0' ORDER BY ChangeNo ASC");
                        while($result3 = mysqli_fetch_assoc($sql2)) {
                          print('<tr><td>'.$result3['ChangeNo'].'</td><td>'.$FoodName.'</td><td>'.$result3['Sheets'].'</td><td><a href="c-changestatus.php?id='.$result3['ChangeNo'].'" class="btn"><font size="3"><b>ステータス変更</b></font></a></td></tr>');
                        }
                    }
                    
                ?>
              </table>
            </div>
        </div>
    </div>