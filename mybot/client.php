<?php
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	include (__DIR__ . '/TelegramClient.php');
	$startScript = microtime(true);
	$currentTime = time();

	$telegramClient = new TelegramClient();

	$count = 1;
	$channel = '';
	$photo = '';
	$usersType = 'channelParticipantsRecent';

	if (array_key_exists('channel', $_POST)) {
		$channel = $_POST['channel'];
	}

	if (array_key_exists('photo', $_POST)) {
		$photo = $_POST['photo'];
	}

	if (array_key_exists('users_type', $_POST)) {
		$usersType = $_POST['users_type'];
		switch ($usersType) {
			case 'admins':
				$usersType = 'channelParticipantsAdmins';			
				break;
			
			case 'bots':
				$usersType = 'channelParticipantsBots';
				break;
			
			case 'all':
				$usersType = 'channelParticipantsAll'; // кастомный тип данных 
				break;

			default:
				$usersType = 'channelParticipantsRecent';
				break;
		}
	}

	$messages = [];
	$users = [];

	if ($usersType == 'channelParticipantsAll') {
		$messages = $telegramClient->getFullChannelInfo($channel);
	} else {
		$messages = $telegramClient->getChannelUsersFull($channel, $usersType);
	}
	
	$me = $telegramClient->getMe();
	$firstName = getArrayKey('first_name', $me['result']);
	$lastName = getArrayKey('last_name', $me['result']);
	$userName = getArrayKey('username', $me['result']);

	//vardump($me);
	//return;
	
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
					<p class="text-left">
						<? echo 'Скрипт был выполнен за ' . (microtime(true) - $startScript) . ' секунд'; ?>
					</p>
					
					<div>
						<a class="btn btn-primary" href="/" role="button">вернуться назад</a>
					</div>

					<dl class="row">
						<dt class="col-sm-3">Полное имя</dt>
  					<dd class="col-sm-9"><?= $firstName . ' ' . $lastName; ?></dd>

						<dt class="col-sm-3">Группа</dt>
  					<dd class="col-sm-9"><?= $channel; ?></dd>

						<dt class="col-sm-3">Username</dt>
  					<dd class="col-sm-9"><?= $userName; ?></dd>
					</dl>

					<? if ($messages['status'] == 'error') { ?>
						<div class="alert alert-danger" role="alert">
							<?= $messages['result']; ?>
						</div>
					<? } ?>
					
					<table class="table table-dark table-striped">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">id</th>
								<!-- <th scope="col">access hash</th> -->
								<th scope="col">username</th>
								<th scope="col">first name</th>
								<th scope="col">last name</th>
								<th scope="col">phone</th>
								<th scope="col">Последний вход<br>(часы)</th>
								<th scope="col">Это бот</th>
							</tr>
						<thead>
						<tbody>
							<? foreach ($messages['result']['users'] as $row) { ?>
								<?
								$hours = '';
								if (array_key_exists('status', $row)) {
									if (array_key_exists('was_online', $row['status'])) {
										$hours = countHoursBetweenDates($currentTime, getArrayKey('was_online', $row['status']));
									}									
								}
								?>
								<tr>
									<th scope="row"><?= $count++; ?></th>
									<td><?= getArrayKey('id', $row); ?></td>
									<!-- <td><?= getArrayKey('access_hash', $row); ?></td> -->
									<td>@<?= getArrayKey('username', $row); ?></td>
									<td class="overflow-hidden"><?= getArrayKey('first_name', $row); ?></td>
									<td><?= getArrayKey('last_name', $row); ?></td>
									<td><?= getArrayKey('phone', $row); ?></td>
									<td><?= $hours; ?></td>
									<td><?= getUserType($row); ?></td>
									
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

function countHoursBetweenDates($firsDate, $secondDate) {
	$currentDate = $firsDate;
	$statusDate = $secondDate;
	$seconds = abs($currentDate - $statusDate);
	$hours = floor($seconds / 3600);
	return $hours;
}

function getUserType($row) {
	if (array_key_exists('type', $row)) {
		return $row['type'];
	}

	if (array_key_exists('bot', $row)) {
		return $row['bot'];
	}

	return '';
}

?>