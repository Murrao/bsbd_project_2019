<?php
	require_once 'includes/db.php';
	require_once 'includes/sessions.php';
	
	if (!mySession_start())
	{
		exit("<br><a href='login.php'>Авторизация</a><br> Необходимо авторизоваться!");
	}

	if (isset($_GET['action']) && $_GET['action']=="add")
	{
		if (isset($_COOKIE['SESSID'])) 
		{	
			// информация о пицце
			$sql = 'SELECT view_tittle, view_price FROM flower_view WHERE view_tittle = :view_id';
			$params = [ ':view_id' => strval(trim($_GET['id'])) ];
			$stmt = $db->prepare($sql);
			$stmt->execute($params);
			$view = $stmt->fetch(PDO::FETCH_OBJ);

			if ($view)
			{
				// информация об аккаунте
				$sql_acc = 'SELECT acc_id FROM flower_session WHERE session_id = :sess_id';
				$stmt_acc = $db->prepare($sql_acc);
				$stmt_acc->execute([':sess_id' => $_COOKIE['SESSID']]);
				$acc = $stmt_acc->fetch(PDO::FETCH_OBJ);

				// добавление пиццы в корзину

				$get_order = $db->prepare('SELECT * FROM flower_cart WHERE session_id = :sess_id AND acc_id = :acc_id AND view_tittle = :view_tittle');
			
				$get_order->execute([ ':sess_id' => $_COOKIE['SESSID'], ':acc_id' => $acc->acc_id, ':view_tittle' => $view->view_tittle ]);
				$order = $get_order->fetch(PDO::FETCH_OBJ);

				if ($order)
				{
					// обновляем текущую позицию



					$add_cart_sql = 'UPDATE flower_cart SET count = :new_count
									 WHERE acc_id = :acc_id AND view_tittle = :view_tittle';

					$add_cart_params = [ 
										 ':new_count' => $order->count + 1, 
										 ':acc_id' => $acc->acc_id, 
										 ':view_tittle' => $view->view_tittle
									   ];
				}
				else
				{
					$add_cart_sql = 'INSERT INTO flower_cart (session_id, price, count, view_tittle, acc_id) 
								 	 VALUES (:sess_id, :price, :count, :view_tittle, :acc_id)';
					$add_cart_params = [ ':sess_id' => $_COOKIE['SESSID'], 
										 ':price' => $view->view_price, 
										 ':count' => 1, 
										 ':view_tittle' => $view->view_tittle, 
										 ':acc_id' => $acc->acc_id
									   ];
				}

				$stmt = $db->prepare($add_cart_sql);
				$stmt->execute($add_cart_params);
			}
		}
	}

	if (isset($_GET['action']) && $_GET['action']=="drop")
	{
		$sql = 'DELETE FROM flower_cart WHERE session_id = :sess_id AND view_tittle = :view_id';
		$params = [  'sess_id' => $_COOKIE['SESSID'],
				     ':view_id' => strval(trim($_GET['id'])) 
				  ];
		$stmt = $db->prepare($sql);
		$stmt->execute($params);
	}	


    if (isset($_POST['buy']))
    { 
    	$get_items = 'SELECT * FROM flower_cart WHERE session_id = :sess_id';
    	$stmt = $db->prepare($get_items);
    	$stmt->execute([ ':sess_id' => $_COOKIE['SESSID']]);

    	$order = $stmt->fetch(PDO::FETCH_OBJ);

		if ($order)
		{	
			$order_id = uniqid();

			$update_cart = 'UPDATE flower_cart SET session_id = :new_sess_id, order_id = :order_id WHERE session_id = :sess_id';
			$stmt = $db->prepare($update_cart);
			$stmt->execute([':new_sess_id' => NULL, ':sess_id' => $_COOKIE['SESSID'], ':order_id' => $order_id]);

			$add_order = 'INSERT INTO flower_orders (order_id, order_status, user_id) 
						  SELECT
						  		:order_id AS order_id,
						  		"Обработка заказа" AS order_status,
						  		flower_accounts.user_id AS user_id
						  FROM flower_cart
						  INNER JOIN flower_accounts
						  ON flower_accounts.acc_id = flower_cart.acc_id 
						  LIMIT 1
						 ';
			$stmt = $db->prepare($add_order);
			$stmt->execute([':order_id' => $order_id]);

		}

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
			<cat>
			<?php
				if (mySession_start())
					echo '<a href="lk.php">Личный кабинет</a>';
				else
					echo '<a href="login.php">Авторизация</a>';
			?>
			</cat>
      <cat><a href="cart.php">Корзина</a></cat>
    </div>

			<!-- КОНТЕНТ -->
			<div class="content">
				<div class="wrapper">

					<h1>Корзина</h1> 
					<form method="post" action="cart.php?page=cart"> 
						<table> 
          					<tr> 
            					<th>Название</th> 
            					<th>Количество</th> 
            					<th>Цена</th> 
            					<th>Сумма</th> 
        					</tr> 

        					<?php 

								$sql = 'SELECT * FROM flower_cart WHERE session_id = :sess_id';
        						$stmt = $db->prepare($sql);
        						$stmt->execute([ ':sess_id' => $_COOKIE['SESSID'] ]);

        						$products = '';
        						$counts = 0;
        						$totalprice = 0; 

       
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
								{
									$totalprice += $row['price'] * $row['count'];
							?>
								<tr> 
        							<td><?php echo $row['view_tittle'] ?></td> 
        						    <td><?php echo $row['count'] ?></td>
        							<td><?php echo $row['price'] ?> руб.</td> 
        							<td><?php echo $row['price'] * $row['count'] ?> руб.</td> 
        							<td> <a class="button" 
        								    href="cart.php?page=cart&action=drop&id=<?php echo $row['view_tittle'] ?>">
        									Убрать
        								 </a>  
        							</td>
        						</tr>
        						<?php } ?>

        					<tr> 
                       	 		<td colspan="4">К оплате: <?php echo $totalprice  ?> руб.</td> 
                    		</tr> 

                    		<button class="button" type="submit" name="buy">Оформить заказ</button> 
   
        				</table>
					</form>
				</div>
			</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="footer">
		UFLOR <span>&copy; 2019</span><br>
		<span>Заказ букета на дом: бесплатная доставка.</span>
		</div>
  </div>
  </body>
</html>