<?php
    session_start();
    if(isset($_SESSION['A_UserID']) == '') {
        print('<script>location.href = "index.php";</script>');
    } else {
        $UserID = $_SESSION['A_UserID'];
        require_once('config/config.php');
        $sql = mysqli_query($db_link, "SELECT OrgID FROM tp_user_org WHERE UserID = '$UserID'");
        $resultorg = mysqli_fetch_assoc($sql);
        $OrgID = $resultorg['OrgID'];
        $_SESSION['OrgID'] = $OrgID;
    }
?>
<!DOCTYPE HTML>
<html charset="UTF-8">
    <head>
        <!-- System Properties -->
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <!-- SEO Properties -->
        <!-- Search Engine Block -->
        <meta name="robots" content="noindex,nofollow" />
        <!-- Title -->
        <title>ニュース - Ticper</title>

        <!-- jQuery Import -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Materialize Import -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    </head>
    <body>
        <!-- Navbar -->
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
      <li><a href="o-changestatus.php">混雑度管理メニュー</a></li>
      <li><a href="t-news.php">ニュース</a></li>
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
        M.toast({html: '<?php print($result['UserName']); ?>としてログインしました。'})
      });
    </script>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>ニュース</h3>
                    <form action="t-addnews.php" method="POST">
                        <input type="text" name="news" placeholder="追加したいニュースを入力" class="validate" required>
                        <button type="submit" class="btn">送信</button>
                    </form>
                    <?php
                        require_once('config/config.php');
                        $sql = mysqli_query($db_link, "SELECT * FROM tp_news WHERE OrgID = '$OrgID'");
                        print('<table>');
                        print('<tr><th>内容</th><th>オプション</th></tr>');
                        while($result = mysqli_fetch_assoc($sql)) {
                            print("<tr><td>".$result['News']."</td><td><a href='t-deletenews.php?id=".$result['NewsID']."' class='btn'>削除</a></td></tr>");
                        }
                    ?>  
                </div>
            </div>
        </div>
    </body>
</html>
        