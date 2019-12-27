<?

include (__DIR__ . '/TelegramClient.php');

$from = '';
$to = '';
$id = [];

if (array_key_exists('source', $_POST)) {
  $from = trim($_POST['source']);
  if (empty($from)) {
    die('Не указан источник сообщений.');  
  }
} else {
  die('Не указан источник сообщений.');
}

if (array_key_exists('recipient', $_POST)) {
  $to = trim($_POST['recipient']);
  if (empty($to)) {
    die('Не указан получатель сообщений.');  
  }
} else {
  die('Не указан получатель сообщений.');
}

if (array_key_exists('message_ids', $_POST)) {
  $messageIds = trim($_POST['message_ids']);
  if (empty($from)) {
    die('Не указаны сообщения для пересылки.');  
  }
  $id = preg_split('/\r\n|\r|\n/', $messageIds);
} else {
  die('Не указаны сообщения для пересылки.');
}

$telegramClient = new TelegramClient();
$result = $telegramClient->forwardMessage($from, $to, $id);

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
  <title>Пересылка сообщения</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <div>
          <a class="btn btn-primary" href="/" role="button">вернуться назад</a>
        </div>
        <? if ($result['status'] == 'error') { ?>
          <div class="alert alert-danger" role="alert">
            <?= $result['result']; ?>
          </div>
        <? } else { ?>
          <div class="alert alert-success" role="alert">
            Сообщения пересланы.
          </div>
        <? } ?>
        
      </div>
    </div>
  </div>
   
</body>
</html>