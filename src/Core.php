<?php

namespace ste25\Telegram;

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
            'chat' => ['all']
        ];
        $this->apiMethod = array();
        $this->methodList = [
            'getMe' => [
                'name' => 'test',
                'params' => [
                    'chat_id' => false
                ]
            ],
            'sendMessage' => [
                'name' => 'message',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'forwardMessage' => [
                'name' => 'forward',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'sendPhoto' => [
                'name' => 'photo',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'sendAudio' => [
                'name' => 'audio',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'sendDocument' => [
                'name' => 'document',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'sendVideo' => [
                'name' => 'video',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'sendAnimation' => [
                'name' => 'animation',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'sendPoll' => [
                'name' => 'poll',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'sendChatAction' => [
                'name' => 'chatAction',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'getUserProfilePhotos' => [
                'name' => 'propic',
                'params' => [
                    'chat_id' => false
                ]
            ],
            'getFile' => [
                'name' => 'file',
                'params' => [
                    'chat_id' => false
                ]
            ],
            'kickChatMember' => [
                'name' => 'kick',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'unbanChatMember' => [
                'name' => 'unban',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'restrictChatMember' => [
                'name' => 'restrict',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'promoteChatMember' => [
                'name' => 'promote',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'exportChatInviteLink' => [
                'name' => 'inviteLink',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'setChatTitle' => [
                'name' => 'chatTitle',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'setChatDescription' => [
                'name' => 'chatDescription',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'pinChatMessage' => [
                'name' => 'pin',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'unpinChatMessage' => [
                'name' => 'unpin',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'leaveChat' => [
                'name' => 'leave',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'getChat' => [
                'name' => 'chatInfo',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'getChatAdministrators' => [
                'name' => 'admins',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'getChatMembersCount' => [
                'name' => 'membersCount',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'getChatMember' => [
                'name' => 'member',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'setChatStickerSet' => [
                'name' => 'setSticker',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'deleteChatStickerSet' => [
                'name' => 'deleteSticker',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'answerCallbackQuery' => [
                'name' => 'callbackQuery',
                'params' => [
                    'chat_id' => false
                ]
            ],
            'editMessageText' => [
                'name' => 'editText',
                'params' => [
                    'chat_id' => true,
                    'required' => ['message_id']
                ]
            ],
            'editMessageCaption' => [
                'name' => 'editCaption',
                'params' => [
                    'chat_id' => true,
                    'required' => ['message_id']
                ]
            ],
            'editMessageMedia' => [
                'name' => 'editMedia',
                'params' => [
                    'chat_id' => true,
                    'required' => ['message_id']
                ]
            ],
            'editMessageReplyMarkup' => [
                'name' => 'editMarkup',
                'params' => [
                    'chat_id' => true,
                    'required' => ['message_id']
                ]
            ],
            'stopPoll' => [
                'name' => 'stopPoll',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'deleteMessage' => [
                'name' => 'deleteMessage',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'sendSticker' => [
                'name' => 'sticker',
                'params' => [
                    'chat_id' => true
                ]
            ],
            'getStickerSet' => [
                'name' => 'getStickerSet',
                'params' => [
                    'chat_id' => false
                ]
            ],
            'answerInlineQuery' => [
                'name' => 'inlineQuery',
                'params' => [
                    'chat_id' => false
                ]
            ]
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
                    if($this->methodList[$method]['params']['chat_id']) {
                        foreach($this->chat as $chat) {
                            if(isset($this->params[$method]['chatall'])) {
                                foreach($this->params[$method]['chatall'] as $singleParams) {
                                    $this->execute($ch, $chat, $method, $singleParams);
                                }
                            }
                            if(isset($this->params[$method]['chat' . $chat])) {
                                foreach($this->params[$method]['chat' . $chat] as $singleParams) $this->execute($ch, $chat, $method, $singleParams);
                            }
                        }
                    }
                    if(!empty($this->params[$method]['nochat'])) {
                        foreach($this->params[$method]['nochat'] as $singleParams) {
                            $this->execute($ch, 0, $method, $singleParams);
                        }
                    }
                }
                else {
                    if(!empty($this->chat) && $this->methodList[$method]['params']['chat_id']) {
                        foreach($this->chat as $chat) {
                            $this->execute($ch, $chat, $method);
                        }
                    }
                    else $this->execute($ch, 0, $method);
                }
            }
            curl_close($ch);
            //$this->chat = array();
            $this->apiMethod = array();
            $this->params = array();
            $this->currentParams = [
                'chat' => ['all']
            ];
            $this->keyboardOptions = [
                'type' => '',
                'rows' => array(),
                'currentRow' => 1,
                'buttonList' => array()
            ];
        }
        return;
    }

    /**
     * Perform cURL requests and set responses.
     * 
     * @param curl $ch
     * @param string|int $chat
     * @param string $method
     * @param array $params
     */
    private function execute($ch, $chat, $method, $params = null)
    {
        $this->request['chat'.$chat][$this->methodList[$method]['name']][] = (!empty($chat)) ? ($this->apiUrl . $method . '?chat_id=' . $chat . (empty($params) ? '' : ('&' . http_build_query($params)))) : $this->apiUrl . $method . (empty($params) ? '' : ('?' . http_build_query($params)));
        curl_setopt($ch, CURLOPT_URL, end($this->request['chat'.$chat][$this->methodList[$method]['name']]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);
        $this->success['chat'.$chat][$this->methodList[$method]['name']][] = $response['ok'];
        $this->result['chat'.$chat][$this->methodList[$method]['name']][] = isset($response['result']) ? $response['result'] : $response['error_code'] . ' - ' . $response['description'];
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
     * 
     * @param string $method
     * @param array $params
     */
    protected function addParams($method, $params)
    {
        if(!$this->methodList[$method]['params']['chat_id']) {
            if(!isset($this->params[$method]['nochat'])) $this->params[$method]['nochat'] = array();
            $this->params[$method]['nochat'] = array_merge($this->params[$method]['nochat'], $params);
            return;
        }
        if(isset($this->methodList[$method]['params']['required'])) {
            if(!isset($this->params[$method]['nochat'])) $this->params[$method]['nochat'] = array();
            $delete = [];
            foreach($params as $key => $param) {
                foreach($this->methodList[$method]['params']['required'] as $required) {
                    if(!isset($param[$required])) {
                        $this->params[$method]['nochat'] = array_merge($this->params[$method]['nochat'], [$param]);
                        $delete[] = $key;
                        break;
                    }
                }
            }
            foreach($delete as $key) unset($params[$key]);
        }
        if(!empty($params)) {
            foreach($this->currentParams['chat'] as $chat) {
                if(!isset($this->params[$method]['chat' . $chat])) $this->params[$method]['chat' . $chat] = array();
                $this->currentParams['index']['chat' . $chat] = ['start' => count($this->params[$method]['chat' . $chat])];
                $this->params[$method]['chat' . $chat] = array_merge($this->params[$method]['chat' . $chat], $params);
                $this->currentParams['index']['chat' . $chat]['end'] = count($this->params[$method]['chat' . $chat]);
            }
        }
        return;
    }

    /**
     * Check input and add method to list.
     * 
     * @param array $args
     * @param array $api
     */
    protected function setParams($args, $api)
    {
        if(!isset($this->apiMethod[$api['name']])) $this->apiMethod[$api['name']] = $api['name'];
        if(is_array($args[0])) $this->addParams($api['name'], $this->manageParams($args[0], $api['params']));
        else $this->addParams($api['name'], [$this->changeKeys($args, $api['params'])]);
        $this->currentParams['method'] = $api['name'];
        return;
    }

    /**
     * Set an array with method's original name and params' name.
     * 
     * @param string $name
     * @param array $params
     * @return array
     */
    protected function setApi($name, $params)
    {
        return [
            'name' => $name,
            'params' => $params
        ];
    }
}
