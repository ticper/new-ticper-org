<?php
  session_start();
  if(isset($_SESSION['O_UserID']) == '') {
    print("<script>location.href = 'index.php';</script>");
  } else {
    require_once('config/config.php');
    $foodid = $_GET['id'];
    $userid = $_SESSION['O_UserID'];
    $sql = mysqli_query($db_link,"SELECT OrgID FROM tp_user_org WHERE UserID = '$userid'");
    $result = mysqli_fetch_assoc($sql);
    $sql2 = mysqli_query($db_link,"SELECT OrgID FROM tp_food WHERE FoodID = '$foodid'");
    $result2 = mysqli_fetch_assoc($sql2);
    if($result['OrgID'] != $result2['OrgID']){
      print('<script>alert("この食品情報はあなたのアカウントでは閲覧できません");location.href = "s-check.php";</script>');
    }
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
    <title>メニュー - Ticper</title>

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
      <li><a href="qrcheck.php">食券読み込み</a></li>
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
              $sql = mysqli_query($db_link, "SELECT UserName FROM tp_user_booth WHERE UserID = '$UserID'");
              $result = mysqli_fetch_assoc($sql);
              print($result['UserName']);
            ?>
          </a>
        </div>
      </li>
      <li><a href="#!" class="dropdown-trigger" data-target="o-menu">食券管理メニュー<i class="material-icons right">arrow_drop_down</i></a></li>
      <li class="divider"></li>
      <li><a href="o-changestatus.php">混雑度管理メニュー</a></li>
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
    <script>
      $(".dropdown-trigger").dropdown();
      $(document).ready(function(){
        $('.sidenav').sidenav();
      });
    </script>
    <div class="container">
      <div class="row">
        <div class="row s12">
          <h3>ステータスチェック</h3>
          <?php
            $sql = mysqli_query($db_link, "SELECT * FROM tp_food WHERE FoodID = '$foodid'");
            $result = mysqli_fetch_assoc($sql);
            print('<h4>'.$result['FoodName'].'</h4>');
            print('<hr />');
            $sql = mysqli_query($db_link, "SELECT FoodStockFrom, FoodStock, Bought, Used, Bought - Used AS num FROM tp_food WHERE FoodID = '$foodid'");
            $result2 = mysqli_fetch_assoc($sql);
            print('<h5>食券総枚数</h5>'.$result2['FoodStockFrom'].'枚<hr />');
            print('<h5>販売済み枚数</h5>'.$result2['Bought'].'枚<hr />');
            print('<h5>未使用枚数</h5>'.$result2['num'].'枚<hr />');
            print('<h5>使用済み枚数</h5>'.$result2['Used'].'枚<hr />');
            print('<h5>食券残り枚数</h5>'.$result2['FoodStock'].'枚<hr />');
		  ?>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>
