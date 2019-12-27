<?

include (__DIR__ . '/TelegramClient.php');

$arStatus = [];
$recipients = [];
$messageText = '';
$count = 1;

if (array_key_exists('message_text', $_POST)) {
  $messageText = trim($_POST['message_text']);
  if (empty($messageText)) {
    die('Пустое сообщение.');  
  }
} else {
  die('Пустое сообщение');
}


if (array_key_exists('recipients', $_POST)) {
  $recipients = trim($_POST['recipients']);
  if (empty($recipients)) {
    die('Передан пустой список пользователей.');  
  }
  $recipients = preg_split('/\r\n|\r|\n/', $recipients);
} else {
  die('Передан пустой список пользователей или возникла проблема с обработкой списка.');
}

$telegramClient = new TelegramClient();

foreach ($recipients as $recipient) {
  $result = $telegramClient->sendMessage($recipient, $messageText);  
  $arStatus[$recipient] = $result['status'] == 'ok' ? $result['status'] : $result['result'];
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Рассылка сообщения</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Результат рассылки сообщения</h1>
        <div>
          <a class="btn btn-primary" href="/" role="button">вернуться назад</a>
        </div>
        <table class="table table-dark table-striped">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">username</th>
								<th scope="col">Статус</th>
							</tr>
						<thead>
						<tbody>
              
              <? foreach ($arStatus as $username => $status) { ?>
                <tr>
                  <th scope="row"><?= $count++; ?></th>
                  <td><?= $username; ?></td>
                  <td><?= $status; ?></td>
                </tr>
              <? } ?>
              
						</tbody>
					</table>
      </div>
    </div>
  </div>
   
</body>
</html>