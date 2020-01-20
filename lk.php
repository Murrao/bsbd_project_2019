<?php
	require_once 'includes/sessions.php';

	if (!mySession_start())
	{
		header("location: login.php");
	}

?>

<!DOCTYPE HTML>

<html>
	<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> <!--Руссификация, путём определения кодировки-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--Изменение ширины сайта в зависимости от разрешения устр-ва-->
    <title>
		Доставка цветов. Заказать цветы онлайн на дом. От службы доставки UFLOR.
    </title>
    <link rel="stylesheet" type="text/css" href="css/css.css"> <!--Подключение стилей-->
		<link href="https://fonts.googleapis.com/css?family=Amatic+SC|Neucha|Pangolin|Poiret+One|Press+Start+2P|Rubik+Mono+One|Underdog&amp;subset=cyrillic" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script> <!--Подключение jQuery со скриптами-->
    <script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script type="text/javascript" src="js/scrpt.js"></script>
		<script src="js/it.js" language="javascript"></script>
		<link rel="shortcut icon" href="img/log.png">
  </head>
  <body>
	<div class="container">
		<div class="top"><img src="img/logo.png" class="oboi">
		<img src="img/logo1.png" width="200" height="111" style="padding-left: 250px;">
		</div>
    <div class="menu"> <!--Меню-->
      <cat><a href="index.php">Главная</a></cat>
      <cat><a href="classic.php">Букеты цветов</a></cat>
      <cat><a href="sostav.php">Состав букетов</a></cat>
			<cat><a href="logout.php">Выйти</a></cat>
      <cat><a href="cart.php">Корзина</a></cat>
    </div>

			<!-- КОНТЕНТ -->
			<div class="content">
				<div class="wrapper">

					<b>Добро пожаловать!</b>

					<?php 

						$sql = 'SELECT * FROM flower_users 
								INNER JOIN flower_accounts ON flower_accounts.user_id = flower_users.u_id 
								INNER JOIN flower_session ON flower_session.acc_id = flower_accounts.acc_id 
								INNER JOIN flower_availability ON flower_availability.acc_id = flower_accounts.acc_id
								WHERE flower_session.session_id = :sess_id';
						$stmt = $db->prepare($sql);
 						$stmt->execute([':sess_id' => $_COOKIE['SESSID']]);
 						$user = $stmt->fetch(PDO::FETCH_OBJ);

 						echo '<br>Вы вошли на сайт, как <u>'.$user->u_name.'</u>
 							  <br>На вашем счету '.$user->amount.' руб.
 							 ';

 						if ($user->u_role == 'admin')
 						{

 							echo "<br><br>Меню:
 							  <br><a href='orders.php' class='button'> Заказы</a>
 							";
 						
 						}
 		
					?>

					
				</div>
			</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="footer">
		UFLOR <span>&copy; 2019</span><br>
		<span>Заказ букета на дом: бесплатная доставка.</span>
		</div>
  </div>
  </body>
</html>