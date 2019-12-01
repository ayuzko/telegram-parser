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
        'address'  => '159.203.81.37',
        'port'     =>  8080
    ];


    $this->MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);
    $this->MadelineProto->start();
    
    //\danog\MadelineProto\Logger::log($me);
  }

  public function getChannelUsers($channel, $offset = 0, $limit = 1000) {
    $users = [
      'status' => 'ok', 
      'result' => array()
    ];

    try {
      //информация об участниках группы
      $users['result'] = $this->MadelineProto->channels->getParticipants(
        [
          'channel' => $channel, 
          'filter' => ['_' => 'channelParticipantsRecent'], 
          'offset' => $offset, 
          'limit' => $limit
        ]
      );
      
    } catch (\Throwable $th) {
      $users['status'] = 'error';
      $users['result'] = 'Ошибка ' . $th->getMessage();
    }
    return $users;
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