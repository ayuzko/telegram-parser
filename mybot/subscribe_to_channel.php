<?

include (__DIR__ . '/TelegramClient.php');

$arUserId = [];
$channel = '';

if (array_key_exists('list_users_id', $_POST)) {
  $listUser = trim($_POST['list_users_id']);
  if (empty($listUser)) {
    die('Передан пустой список пользователей.');  
  }
  $arUserId = preg_split('/\r\n|\r|\n/', $listUser);
} else {
  die('Передан пустой список пользователей или возникла проблема с обработкой списка.');
}

if (array_key_exists('channel', $_POST)) {
  $channel = trim($_POST['channel']);
  if (empty($listUser)) {
    die('Канал не заполнен.');  
  }
}

$telegramClient = new TelegramClient();
$result = $telegramClient->subscribeToChannel($channel, $arUserId);
$a = 0;


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
  <title>Подписка на канал</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <? if ($result['status'] == 'ok') { ?>
          <div class="alert alert-success" role="alert">
            Пользователи подписаны успешно.
          </div>
        <? } else { ?>
          <div class="alert alert-danger" role="alert">
            <?= $result['result']; ?>
          </div>
        <? } ?>
      </div>
    </div>
  </div>
   
</body>
</html>