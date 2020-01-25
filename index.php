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
						<fieldset class="form-group border p-2">
							<legend class="w-auto">Выберите тип участников</legend>
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" name="users_type" value="users" id="r_users" checked>
								<label class="custom-control-label" for="r_users">
									Участники
								</label>
							</div>
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" name="users_type" value="admins" id="r_admins">
								<label class="custom-control-label" for="r_admins">
									Админы
								</label>
							</div>
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" name="users_type" value="bots" id="r_bots">
								<label class="custom-control-label" for="r_bots">
									Боты
								</label>
							</div>
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" name="users_type" value="all" id="r_all">
								<label class="custom-control-label" for="r_all">
									Все
								</label>
							</div>
						</fieldset>
					</div>
					<button class="btn btn-primary btn-sm" type="submit">Выполнить</button>
				</form>		
			</div>	
		</div>

		<div class="row">
			<div class="col">
				<form action="mybot/subscribe_to_channel.php" method="post">
					<div class="form-group">
						<h1>Инвайт пользователей в группу/канал</h1>
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

		<div class="row">
			<div class="col">
				<form action="mybot/send_message.php" method="post">
					<div class="form-group">
						<h1>Рассылка нового сообщения</h1>
						<div class="">
							<label>Список получателей:</label>
							<textarea class="form-control form-control-sm" type="text" name="recipients" cols="10" rows="10" value="" placeholder="Введите получетелей, каждый с новой строки в одном из форматов @username, username, id пользоватля, https://t.me/joinchat/*, https://t.me/*"></textarea>
						</div>
						<div>
							<label>Сообщение: </label>
							<textarea class="form-control form-control-sm" name="message_text" id="" cols="10" rows="10" placeholder="Введите сообщение, поддерживается разметка markdown"></textarea>
						</div>
					</div>
					<button class="btn btn-primary btn-sm" type="submit">Отправить сообщение</button>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<form action="mybot/forward_message.php" method="post">
					<div class="form-group">
						<h1>Перессылка сообщений</h1>
						<div class="">
							<label>Источник сообщений (от куда надо взять):</label>
							<input class="form-control form-control-sm" type="text" name="source" value="" placeholder="Введите источник сообщений в одном из форматов @username, username, id пользоватля, https://t.me/joinchat/*, https://t.me/*"></input>
						</div>
						<div class="">
							<label>Получатель сообщений (куда надо переслать):</label>
							<input class="form-control form-control-sm" type="text" name="recipient" value="" placeholder="Введите получателя сообщений в одном из форматов @username, username, id пользоватля, https://t.me/joinchat/*, https://t.me/*"></input>
						</div>
						<div>
							<label>Сообщения id: </label>
							<textarea class="form-control form-control-sm" name="message_ids" id="" cols="10" rows="10" placeholder="Введите id сообщений, каждый id на новой строке"></textarea>
						</div>
					</div>
					<button class="btn btn-primary btn-sm" type="submit">Переслать сообщения</button>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<form action="mybot/delete_message.php" method="post">
					<div class="form-group">
						<h1>Очистить канал от сообщений</h1>
						<div class="">
							<label>Источник сообщений:</label>
							<input class="form-control form-control-sm" type="text" name="source" value="" placeholder="Введите источник сообщений в одном из форматов @username, username, id пользоватля, https://t.me/joinchat/*, https://t.me/*"></input>
						</div>
					</div>
					<button class="btn btn-primary btn-sm" type="submit">Очистить</button>
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