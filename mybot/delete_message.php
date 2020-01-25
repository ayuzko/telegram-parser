<?

include (__DIR__ . '/TelegramClient.php');

$channel = '';

if (array_key_exists('source', $_POST)) {
  $channel = trim($_POST['source']);
} else {
  die('Передан пустое название канала.');
}

if (empty($channel)) {
  die('Передан пустое название канала.');
}


$telegramClient = new TelegramClient();
$result = $telegramClient->getMassages($channel);

$idMessage = [];
foreach ($result['result']['messages'] as $message) {
  $idMessage[] = $message['id'];
}

$result = $telegramClient->deleteMessage($channel, $idMessage);

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
  <title>Очистка канала от сообщений</title>
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
            Сообщения удалены из канала
          </div>
        <? } ?>
        
      </div>
    </div>
  </div>
   
</body>
</html>