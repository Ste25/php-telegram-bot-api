<?php

namespace ste25\TelegramBot;

/**
 * Core class.
 * 
 * @author https://github.com/Ste25
 */
class Core
{
    private $apiUrl;
    protected $chat;
    protected $currentParams;
    protected $apiMethod;
    protected $methodName;
    protected $params;
    protected $keyboardOptions;
    protected $result;
    protected $success;
    protected $request;
    
    public function __construct($token)
    {
        $this->apiUrl = 'https://api.telegram.org/bot' . $token . '/';
        $this->chat = array();
        $this->currentParams = [
            'chat' => [0]
        ];
        $this->apiMethod = array();
        $this->methodName = [
            'getMe' => 'test',
            'sendMessage' => 'message',
            'forwardMessage' => 'forward',
            'sendPhoto' => 'photo',
            'sendAudio' => 'audio',
            'sendDocument' => 'document',
            'sendVideo' => 'video',
            'sendAnimation' => 'animation',
            'sendPoll' => 'poll',
            'sendChatAction' => 'chatAction',
            'getUserProfilePhotos' => 'propic',
            'getFile' => 'file',
            'kickChatMember' => 'kick',
            'unbanChatMember' => 'unban',
            'restrictChatMember' => 'restrict',
            'promoteChatMember' => 'promote',
            'exportChatInviteLink' => 'inviteLink',
            'setChatTitle' => 'chatTitle',
            'setChatDescription' => 'chatDescription',
            'pinChatMessage' => 'pin',
            'unpinChatMessage' => 'unpin',
            'leaveChat' => 'leave',
            'getChat' => 'chatInfo',
            'getChatAdministrators' => 'admins',
            'getChatMembersCount' => 'membersCount',
            'getChatMember' => 'member',
            'setChatStickerSet' => 'setSticker',
            'deleteChatStickerSet' => 'deleteSticker',
            'answerCallbackQuery' => 'callbackQuery'
        ];
        $this->params = array();
        $this->keyboardOptions = [
            'type' => '',
            'rows' => array(),
            'currentRow' => 1,
            'buttonList' => array()
        ];
    }

    /**
     * Execute all prepared methods.
     */
    public function send()
    {
        if(!empty($this->apiMethod)) {
            $this->result = array();
            $this->success = array();
            $this->request = array();
            $ch = curl_init();
            foreach($this->apiMethod as $method) {
                if(!empty($this->params[$method])) {
                    foreach($this->chat as $chat) {
                        if(isset($this->params[$method][0])) {
                            foreach($this->params[$method][0] as $singleParams) {
                                $this->execute($ch, $chat, $method, $singleParams);
                            }
                        }
                        if(isset($this->params[$method][$chat])) {
                            foreach($this->params[$method][$chat] as $singleParams) $this->execute($ch, $chat, $method, $singleParams);
                        }
                    }
                }
                else {
                    if(!empty($this->chat)) {
                        foreach($this->chat as $chat) {
                            $this->execute($ch, $chat, $method);
                        }
                    }
                    else $this->execute($ch, 0, $method);
                }
            }
            curl_close($ch);
            $this->apiMethod = array();
        }
        return;
    }

    /**
     * Perform cURL requests and set responses.
     */
    private function execute($ch, $chat, $method, $params = null)
    {
        $this->request['chat'.$chat][$this->methodName[$method]][] = (!empty($chat)) ? ($this->apiUrl . $method . '?chat_id=' . $chat . (empty($params) ? '' : ('&' . http_build_query($params)))) : $this->apiUrl . $method;
        curl_setopt($ch, CURLOPT_URL, end($this->request['chat'.$chat][$this->methodName[$method]]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);
        $this->success['chat'.$chat][$this->methodName[$method]][] = $response['ok'];
        $this->result['chat'.$chat][$this->methodName[$method]][] = isset($response['result']) ? $response['result'] : $response['error_code'] . ' - ' . $response['description'];
        return;
    }

    /**
     * Change array's keys.
     * 
     * @param array $array
     * @param array $newKeys
     * @return array
     */
    protected function changeKeys($array, $newKeys)
    {
        return array_combine(array_splice($newKeys, 0, count($array)), $array);
    }

    /**
     * Reorder parameters and check keys.
     * 
     * @param array $array
     * @param array $paramsName
     * @return array
     */
    protected function manageParams($array, $paramsName)
    {
        $return = array();
        if(isset($array[0])) {
            if(is_array($array[0])) {
                foreach($array as $single) {
                    if(isset($single[$paramsName[0]])) $return[] = $single;
                    else $return[] = $this->changeKeys($single, $paramsName);
                }
            }
            else {
                $return[] = $this->changeKeys($array, $paramsName);
            }
        }
        else {
            $return[] = $array;
        }
        return $return;
    }

    /**
     * Add params to list.
     */
    protected function addParams($method, $params)
    {
        foreach($this->currentParams['chat'] as $chat) {
            if(!isset($this->params[$method][$chat])) $this->params[$method][$chat] = array();
            $this->currentParams['index'][$chat] = ['start' => count($this->params[$method][$chat])];
            $this->params[$method][$chat] = array_merge($this->params[$method][$chat], $params);
            $this->currentParams['index'][$chat]['end'] = count($this->params[$method][$chat]);
        }
        return;
    }
}
