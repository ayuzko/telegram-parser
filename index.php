<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Парсер telegram</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col">
				<!-- <nav class="nav flex-column justify-content-center">
					<a class="nav-link" href="mybot/get_users.php">Получить участников канала/группы/чата</a>
					<a class="nav-link" href="mybot/subscribe_to_channel.php">Подписать пользователей на канал/группу/чат</a>
				</nav> -->
				<form action="mybot/client.php" method="post">
					<div class="form-group">
					
						<h1>Получить участников канала/группы/чата</h1>
						<div class="">
							<label>Телеграм-канал:</label>
							<input class="form-control form-control-sm" type="text" name="channel" value="javascript_jobs" placeholder="Введите название группы/канала/чата в формате https://t.me/offers_banggood или offers_banggood">
							
						</div>
						<div class="form-group form-check">
							<input class="form-check-input" type="checkbox" name="photo" value="true" id="photo">
							<label class="form-check-label" for="photo">Получить фото пользователей канала</label>
						</div>
					</div>
					<button class="btn btn-primary btn-sm" type="submit">Выполнить</button>
				</form>		
			</div>	
		</div>

		<div class="row">
			<div class="col">
				<form action="mybot/subscribe_to_channel.php" method="post">
					<div class="form-group">
						<h1>Канала/группа/чат для подписи</h1>
						<div class="">
							<label>Телеграм-канал:</label>
							<input class="form-control form-control-sm" type="text" name="channel" value="javascript_jobs" placeholder="Введите название группы/канала/чата в формате https://t.me/offers_banggood или offers_banggood">
						</div>
						<div>
							<label>Список пользователей (username)</label>
							<textarea class="form-control form-control-sm" name="list_users_id" id="" cols="10" rows="10" placeholder="Введите в одну колонку @username или username"></textarea>
						</div>
					</div>
					<button class="btn btn-primary btn-sm" type="submit">Подписать пользователей</button>
				</form>
			</div>
		</div>
	</div>

	<div class="errors-wrapper" style="color: red; display: none"></div>
	<div class="sucess-wrapper" style="color: red; display: none"></div>
	<script src="js/vendor/jquery-3.4.1.js"></script>
	<script src="js/custom.js"></script>
</body>
</html>