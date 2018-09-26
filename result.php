<?php
	session_start();
	require_once('config/config.php');
	$acode = $_GET['acode'];
	if(isset($_SESSION['O_UserID']) == ''){
		print("<script>alert('ログインしてからアクセスして下さい'); location.href = 'qrcheck.php';</script>");
	} else {

	}

	if($acode == '') {
		print("<script>alert('不正なリクエスト');location.href = 'qrcheck.php';</script>");
	}
	$sql = mysqli_query($db_link, "SELECT Used,Sheets,FoodID FROM tp_ticket WHERE TicketACode = '$acode'");
	$userid = $_SESSION['O_UserID'];
	$result = mysqli_fetch_assoc($sql);
	$check = $result['Used'];
	$seets = $result['Sheets'];
	$foodid = $result['FoodID'];
	if($check != '0') {
		print("<script>alert('この食券は使用済みです');location.href = 'qrcheck.php';</script>");
	}

	$sql2 = mysqli_query($db_link,"SELECT OrgID FROM tp_user_org WHERE UserID = '$userid'");
	$result2 = mysqli_fetch_assoc($sql2);
	$orgid = $result2['OrgID'];

	$sql3 = mysqli_query($db_link,"SELECT OrgID FROM tp_food WHERE FoodID = '$foodid'");
	$result3 = mysqli_fetch_assoc($sql3);
	$s_orgid = $result3['OrgID'];

	if($orgid != $s_orgid){
		print("<script>alert('このQRはあなたの団体では使用できません。もう一度確認して下さい');location.href = 'qrcheck.php';</script>");
	} else {
		mysqli_query($db_link, "UPDATE tp_ticket SET Used = '1' WHERE TicketACode = '$acode'");
		mysqli_query($db_link, "UPDATE tp_food SET Used = Used + '$seets' WHERE FoodID = '$foodid'");
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
		<title>アクティベート</title>

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
					<h3>食券を使用しました</h3>
					<p>次の食品を提供して下さい</p>
					<table>
						<thead>
							<tr>
								<th>食品名</th>
								<th>枚数</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql = mysqli_query($db_link,"SELECT FoodID,Sheets FROM tp_ticket WHERE TicketACode = $acode");
								$result = mysqli_fetch_assoc($sql);
								$foodid = $result['FoodID'];
								$sql2 = mysqli_query($db_link,"SELECT FoodName FROM tp_food WHERE FoodID = '$foodid'");
								$result2 = mysqli_fetch_assoc($sql2);
								$foodname = $result2['FoodName'];
								print('<tr>');
								print('<td>');
								print($foodname);
								print('</td>');
								print('<td>');
								print($result['Sheets']);
								print('</td>');
								print('</tr>');
							?>
						</tbody>
					</table>
					<p><a class="btn" href="qrcheck.php">読み込みに戻る</a></p>
					<p><a class="btn" href="o-changestatus.php">混雑度を変更する</a></p>
       			</div>
      		</div>
    	</div>
	</body>
</html>