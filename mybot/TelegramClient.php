<?php
use danog\MadelineProto\Stream\Proxy\HttpProxy;

use danog\MadelineProto\Stream\Proxy\SocksProxy;

class TelegramClient {
  private $MadelineProto;

  public function __construct() {

    //Подключение Madeline с гитхаба
    if (!file_exists(__DIR__ . '/madeline.php')) {
      copy('https://phar.madelineproto.xyz/madeline.php', __DIR__ . '/madeline.php');
    }
    include __DIR__ . '/madeline.php';
  
    // если показывает что ошибка подключиния к DC5 или DC2, то включить прокси

    $settings['connection_settings']['all']['proxy'] = HttpProxy::getName();
    $settings['connection_settings']['all']['proxy_extra'] = [
        // 'address'  => '51.158.120.84',
        // 'port'     =>  8811
        'address'  => '40.67.219.227',
        'port'     =>  3128
    ];
    $settings['app_info']['api_id'] = '1082070';
    $settings['app_info']['api_hash'] = '3578ffef93bf3f9d434245ee0559032c';


    $this->MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);
    $this->MadelineProto->start();
    
    //\danog\MadelineProto\Logger::log($me);
  }

  public function getMessagesViews() {
    $result = [
      'status' => 'ok', 
      'result' => array()
    ];

    $paremetr = ['peer' => 'itemschina', 'id' => [109], 'increment' => true, ];

    try {
      //$views = $this->MadelineProto->messages->getMessagesViews($paremetr);
      $dialog = $this->MadelineProto->get_dialogs();
      $history = $this->MadelineProto->messages->getHistory(['peer' => '@itemschina', 'offset_id' => 0, 'offset_date' => 0, 'add_offset' => 0, 'limit' => 200, 'max_id' => 1000, 'min_id' => 0]);
      $views = $this->MadelineProto->messages->readHistory(['peer' => 1206532903, 'max_id' => 1000]);
      $result['result'] = $views;
    } catch (\Throwable $th) {
      $users['status'] = 'error';
      $users['result'] = 'Ошибка ' . $th->getMessage();
    }
    return $result;
  }

  public function getMe() {
    $result = [
      'status' => 'ok', 
      'result' => array()
    ];
    try {
      $me = $this->MadelineProto->getSelf();
      $result['result'] = $me;
    } catch (\Throwable $th) {
      $result['status'] = 'error';
      $result['result'] = 'Ошибка ' . $th->getMessage();
    }
    return $result;
  }

  /**
   * максиму можно получить 10000 пользователей
   * ограничение сервера телеграм
   */
  public function getChannelUsersFull($channel, $filter = 'channelParticipantsRecent') {
    $result = [
      'status' => 'ok',
      'result' => [
        'users' => [] 
      ]
    ];
    $offset = 0;
    $limit = 200;

    while (true) {
      $res = $this->getChannelUsers($channel, $offset, $limit, $filter);
      
      if ($res['status'] == 'error') {
        $result['status'] = $res['status'];
        $result['result'] = $res['result'];
        break;
      }

      $countUsers = count($res['result']['users']);
      $result['result']['users'] = array_merge($result['result']['users'], $res['result']['users']);

      if ($countUsers == 0) {
        break;
      }
      $offset += $countUsers;
    }
    return $result;
  }

  public function getChannelUsers($channel, $offset = 0, $limit = 100, $filter = 'channelParticipantsRecent', $hash = []) {
    $users = [
      'status' => 'ok', 
      'result' => array()
    ];

    try {
      $users['result'] = $this->MadelineProto->channels->getParticipants(
        [
          'channel' => $channel, 
          'filter' => ['_' => $filter],
          'offset' => $offset, 
          'limit' => $limit,
          'hash' => $hash
        ]
      );
      
    } catch (\Throwable $th) {
      $users['status'] = 'error';
      $users['result'] = 'Ошибка ' . $th->getMessage();
    }
    return $users;
  }

  /**
   * получает всех пользователей, больше 10000
   */
  public function getFullChannelInfo($channel) {
    $result = [
      'status' => 'ok', 
      'result' => array()
    ];

    try {
      $result['result'] = $this->MadelineProto->get_pwr_chat($channel);

      if (array_key_exists('participants', $result['result'])) {
        $users = array_column($result['result']['participants'], 'user');
        $result['result'] = array('users' => $users);
      }
    } catch (\Throwable $th) {
      $result['status'] = 'error';
      $result['result'] = 'Ошибка ' . $th->getMessage();
    }
    return $result;
  }

  public function subscribeToChannel($channel, $users) {
    $result = [
      'status' => 'ok',
      'result' => ''
    ];
    try {

      $result['result'] = $this->MadelineProto->channels->inviteToChannel(
        [
          'channel' => $channel, 
          'users' => $users
        ]
      );
    } catch (\Throwable $th) {
      $result['status'] = 'error';
      $result['result'] = 'Ошибка ' . $th->getMessage();
    }
    

    return $result;
  }

  public function forwardMessage($fromPeer, $toPeer, $idMessage, $silent = true, $background = true, $withMyScope = false, $grouped = false, $schedule = 0) {
    $result = [
      'status' => 'ok',
      'result' => ''
    ];

    try {
      $Updates = $this->MadelineProto->messages->forwardMessages([
        'silent' => $silent, 
        'background' => $background, 
        'with_my_score' => $withMyScope, 
        'grouped' => $grouped, 
        'from_peer' => $fromPeer, 
        'id' => $idMessage, 
        'to_peer' => $toPeer, 
        'schedule_date' => $schedule 
      ]);

      $result['result'] = $Updates;
    } catch (\Throwable $th) {
      $result['status'] = 'error';
      $result['result'] = 'Ошибка ' . $th->getMessage();
    }
    return $result;
  }

  /** 
   * @param string $peer пользователь, куда отправить это сообщение
   * @param bool $no_webpage отключить предварительный просмотр веб-страницы
   * @param bool $silent отключить уведомления ? на телефоне ничего всплывать не будет если true
   * @param bool $background отключить фоновые уведомления ? необязательное
   * @param bool $clear_draft очистить черновик сообщения этого чата ? необязательное
   * @param int $reply_to_msg_id ответить на сообщение по ID. необязательное
   * @param string $message сообщение для отправки
   * @param ReplyMarkup $reply_markup клавиатуры для отправки
   * @param array $entities [MessageEntity] объекты для отправки (для стилизованного текста)
   * @param string $parse_mode анализировать ли разметку HTML или Markdown в сообщении
   * @param int $schedule_date дата графика
  */
  public function sendMessage(
    $peer, 
    $message, 
    $no_webpage = true, 
    $background = true, 
    $silent = true, 
    $clear_draft = false, 
    $reply_to_msg_id = null, 
    $reply_markup = null, 
    $entities = null, 
    $parse_mode = 'Markdown',
    $schedule_date = 0) {

    $result = [
      'status' => 'ok',
      'result' => ''
    ];
    try {

      $Updates = $this->MadelineProto->messages->sendMessage(
        [
          'no_webpage' => $no_webpage,            // Отключить предварительный просмотр веб-страницы ? необязательное
          'silent' => $silent,                    // Отключить уведомления ? необязательное
          'background' => $background,            // Отключить фоновые уведомления ? необязательное
          'clear_draft' => $clear_draft,          // Очистить черновик сообщения этого чата ? необязательное
          'peer' => $peer,                        // куда отправить это сообщение ? необязательное
          'reply_to_msg_id' => $reply_to_msg_id,  // Ответить на сообщение по ID (int). необязательное
          'message' => $message,                  // Сообщение для отправки
          'reply_markup' => $reply_markup,        // Клавиатуры для отправки	
          'entities' => $entities,                // Объекты для отправки (для стилизованного текста)
          'parse_mode' => $parse_mode,            // Анализировать ли разметку HTML или Markdown в сообщении
          'schedule_date' => $schedule_date       // Дата графика
        ]
      );

      $result['result'] = $Updates;

    } catch (\Throwable $th) {
      $result['status'] = 'error';
      $result['result'] = 'Ошибка ' . $th->getMessage();
    }
    

    return $result;
  }

  public function searchContact($username) {
    $result = [
      'status' => 'ok',
      'result' => ''
    ];
    try {

      $Updates = $this->MadelineProto->contacts->search(['q' => $username, 'limit' => 10, ]);
        
      $result['result'] = $Updates;

    } catch (\Throwable $th) {
      $result['status'] = 'error';
      $result['result'] = 'Ошибка ' . $th->getMessage();
    }
    

    return $result;
  }

  public function getUserPhoto($userId, $dirForPhoto, $offset = 0, $limit = 10) {
    $photos_Photos = $this->MadelineProto->photos->getUserPhotos(
      [
        'user_id' => $userId, 
        'offset' => $offset, 
        'max_id' => '0', 
        'limit' => $limit,
      ]
    );
  
    if (array_key_exists('photos', $photos_Photos)) {
  
      foreach ($photos_Photos['photos'] as $photo) {
        $photoInfo = $this->MadelineProto->get_download_info($photo);
        $photoExtension = $photoInfo['ext'];
        $pathname = $dirForPhoto . $userId . '_' . $photoInfo['name'] . $photoExtension;
        $this->MadelineProto->download_to_file($photo, $pathname);
        // $MadelineProto->download_to_dir($photoInfo, '/home/user/Загрузки/1/');
      }
  
    }
  }
}

?>