<?php
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	include (__DIR__ . '/TelegramClient.php');
	$startScript = microtime(true);


	$telegramClient = new TelegramClient();

	$count = 0;
	$channel = '';
	$photo = '';

	if (array_key_exists('channel', $_POST)) {
		$channel = $_POST['channel'];
	}

	if (array_key_exists('photo', $_POST)) {
		$photo = $_POST['photo'];
	}

	$messages = [];
	$users = [];

	
	$messages = $telegramClient->getChannelUsers($channel, 0, 100);

	echo 'Скрипт был выполнен за ' . (microtime(true) - $startScript) . ' секунд';
	//vardump($messages);
?>

<html>
	<head>
  	<meta charset="utf-8">
		<title>Тег META, атрибут charset</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css">		
 	</head>
 	<body>
		<div class="container">
			<div class="row">
				<div class="col">
					<table class="table table-dark table-striped">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">id</th>
								<th scope="col">access hash</th>
								<th scope="col">username</th>
								<th scope="col">first name</th>
								<th scope="col">last name</th>
								<th scope="col">phone</th>
							</tr>
						<thead>
						<tbody>
							<? foreach ($messages['result']['users'] as $row) { ?>
								<tr>
									<th scope="row"><?= $count++; ?></th>
									<td><?= getArrayKey('id', $row); ?></td>
									<td><?= getArrayKey('access_hash', $row); ?></td>
									<td><?= getArrayKey('username', $row); ?></td>
									<td><?= getArrayKey('first_name', $row); ?></td>
									<td><?= getArrayKey('last_name', $row); ?></td>
									<td><?= getArrayKey('phone', $row); ?></td>
									<?
									if ($photo == true) {
										$telegramClient->getUserPhoto($row['id'], '/home/user/Загрузки/1/');
									}
									?>
									
								</tr>
							<? } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
 	</body>
</html>

<?php

function getArrayKey($key, $arr) {
	if (array_key_exists($key, $arr)) {
		return $arr[$key];
	}
	return '';
}

/**
 * Функция выводит массив на экран
 * param  $arr  Array Массив данных
 * param  $var_dump Bool Если true, то выводит в массиве и типы данных
 * Void
 */
function vardump($arr, $var_dump = false)
{
  echo "<pre style='background: #222;color: #54ff00;padding: 20px;'>";
  if ($var_dump){
    var_dump($arr);
  }
  else{
    print_r($arr);
  }
  echo "</pre>";
}

?>