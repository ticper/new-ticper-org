<?php
  session_start();
  if(isset($_SESSION['UserID']) == '') {
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
    <title>混雑度表示 - Ticper</title>

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
      <li><a href="#!">食券情報表示</a></li>
    </ul>
    <ul id="slide-out" class="sidenav">
      <li>
        <div class="user-view">
          <div class="background">
            <img width="100%" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a1/Yamabuki_High_School.JPG/1200px-Yamabuki_High_School.JPG">
          </div>
          <a href="#!user"><img class="circle" src="http://www.yamabuki-hs.metro.tokyo.jp/site/tei/content/000026901.jpg"></a>
          <a href="#!name" style="color: white;">
            <?php
              $UserID = $_SESSION['UserID'];
              require_once('config/config.php');
              $sql = mysqli_query($db_link, "SELECT UserName FROM tp_user_booth WHERE UserID = '$UserID'");
              $result = mysqli_fetch_assoc($sql);
              print($result['UserName']);
            ?>
          </a>
        </div>
      </li>
      <li><a href="#!" class="dropdown-trigger" data-target="o-menu">食券管理メニュー<i class="material-icons right">arrow_drop_down</i></a></li>
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
          <h3>混雑度を変更する</h3>
          <?php
            require_once('config/config.php');
            $userid = $_SESSION['UserID'];
            $sql = mysqli_query($db_link, "SELECT OrgID FROM tp_user_org WHERE UserID = '$userid'");
            $result = mysqli_fetch_assoc($sql);
            $orgid = $result['OrgID'];
            $sql = mysqli_query($db_link, "SELECT Status FROM tp_org WHERE OrgID = '$orgid'");
            $result2 = mysqli_fetch_assoc($sql);
            $status = $result2['Status'];
          ?>
          <form action="o-changestatusdo.php" method="POST">
            <input type="hidden" name="orgid" value="<?php print($result['OrgID']); ?>" />
            <p><b>現在のステータス</b>: 
            <?php
                if($status == 0) {
                    print("空いている");
                } elseif ($status == 1) {
                    print("少し混んでいる");
                } elseif ($status == 2) {
                    print("結構混んでいる");
                } elseif ($status == 3) {
                    print("超混んでいる");
                }
            ?><br>
            <div class="input-field col s12">
                <select name="statuschangeto>
                    <option value="" disabled selected>選択してください。</option>
                    <option value="0">空いている</option>
                    <option value="1">少し混んでいる</option>
                    <option value="2">結構混んでいる</option>
                    <option value="3">超混んでいる</option>
                </select>
            </div>
            <input type="submit" value="送信" class="btn">
          </form>
          <script>
            $(document).ready(function(){
                $('select').formSelect();
            });
          </script>
        </div>
      </div>
    </div>
  </body>
</html>