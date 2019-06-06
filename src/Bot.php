<?php

namespace ste25\Telegram;

use ste25\Telegram\Keyboard;

/**
 * Bot class.
 * 
 * @author https://github.com/Ste25
 */
class Bot extends Keyboard
{
    /**
     * Set bot chat(s).
     * 
     * @param string|int|array $chat
     * @return $this
     */
    public function chat($chat)
    {
        if(!is_array($chat)) $chat = func_get_args();
        $this->chat = array_unique($chat);
        return $this;
    }

    /**
     * Add one or more chat(s).
     * 
     * @param string|int|array $chat
     * @return $this
     */
    public function addChat($chat)
    {
        if(!is_array($chat)) $chat = func_get_args();
        $this->chat = array_unique(array_merge($this->chat, $chat));
        return $this;
    }

    /**
     * Remove one or more chat(s).
     * 
     * @param string|int|array $chat
     * @return $this
     */
    public function removeChat($chat)
    {
        if(!is_array($chat)) $chat = func_get_args();
        $removeList = array();
        foreach($chat as $single) {
            $removeList[] = isset($this->chat[$single]) ? $this->chat[$single] : $single;
        }
        $this->chat = array_diff($this->chat, $removeList);
        return $this;
    }

    /**
     * Get chat list or chat id.
     * 
     * @param string $name
     * @return string|int|array
     */
    public function getChat($name = null)
    {
        if(!empty($name) && isset($this->chat[$name])) return $this->chat[$name];
        else return $this->chat;
    }

    /**
     * Set current chat.
     * 
     * @param string|int|array $chat
     * @return $this
     */
    public function selectChat($chat = 'all')
    {
        $this->currentParams['chat'] = array();
        if($chat === 'all') $this->currentParams['chat'][] = 0;
        else {
            if(!is_array($chat)) $chat = func_get_args();
            foreach($chat as $single) {
                $this->currentParams['chat'][] = isset($this->chat[$single]) ? $this->chat[$single] : $single;
            }
        }
        return $this;
    }

    /**
     * Prepare test if token is correct.
     * 
     * @link https://core.telegram.org/bots/api#getme
     * @return $this
     */
    public function test()
    {
        $this->currentParams['method'] = 'getMe';
        if(!isset($this->apiMethod[$this->methodName['getMe']])) $this->apiMethod[$this->methodName['getMe']] = 'getMe';
        return $this;
    }
    
    /**
     * Prepare a message.
     * 
     * @link https://core.telegram.org/bots/api#sendmessage
     * @param string|array $text
     * @param string $parse_mode
     * @param bool $disable_web_page_preview
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function message($text, $parse_mode = 'markdown', $disable_web_page_preview = false, $disable_notification = false, $reply_to_message_id = null)
    {
        if(!isset($this->apiMethod[$this->methodName['sendMessage']])) $this->apiMethod[$this->methodName['sendMessage']] = 'sendMessage';
        if(is_array($text)) $this->addParams('sendMessage', $this->manageParams($text, ['text', 'parse_mode', 'disable_web_page_preview', 'disable_notification', 'reply_to_message_id']));
        else $this->addParams('sendMessage', [compact('text', 'parse_mode', 'disable_web_page_preview', 'disable_notification', 'reply_to_message_id')]);
        $this->currentParams['method'] = 'sendMessage';
        return $this;
    }

    /**
     * Prepare message to forward.
     * 
     * @link https://core.telegram.org/bots/api#forwardmessage
     * @param string|int $from_chat_id
     * @param int $message_id
     * @param bool $disable_notification
     * @return $this
     */
    public function forward($from_chat_id, $message_id, $disable_notification = false)
    {
        if(!isset($this->apiMethod[$this->methodName['forwardMessage']])) $this->apiMethod[$this->methodName['forwardMessage']] = 'forwardMessage';
        if(is_array($from_chat_id)) $this->addParams('forwardMessage', $this->manageParams($from_chat_id, ['from_chat_id', 'message_id', 'disable_notification']));
        else $this->addParams('forwardMessage', [compact('from_chat_id', 'message_id', 'disable_notification')]);
        $this->currentParams['method'] = 'forwardMessage';
        return $this;
    }

    /**
     * Prepare a photo.
     * 
     * @link https://core.telegram.org/bots/api#sendphoto
     * @param string $photo
     * @param string $caption
     * @param string $parse_mode
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function photo($photo, $caption = '', $parse_mode = 'markdown', $disable_notification = false, $reply_to_message_id = null)
    {
        if(!isset($this->apiMethod[$this->methodName['sendPhoto']])) $this->apiMethod[$this->methodName['sendPhoto']] = 'sendPhoto';
        if(is_array($photo)) $this->addParams('sendPhoto', $this->manageParams($photo, ['photo', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id']));
        else $this->addParams('sendPhoto', [compact('photo', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id')]);
        $this->currentParams['method'] = 'sendPhoto';
        return $this;
    }

    /**
     * Prepare an audio file.
     * 
     * @link https://core.telegram.org/bots/api#sendaudio
     * @param string $audio
     * @param string $caption
     * @param string $parse_mode
     * @param int $duration
     * @param string $performer
     * @param string $title
     * @param string $thumb
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function audio($audio, $caption = '', $parse_mode = 'markdown', $duration = null, $performer = '', $title = '', $thumb = '', $disable_notification = false, $reply_to_message_id = null)
    {
        if(!isset($this->apiMethod[$this->methodName['sendAudio']])) $this->apiMethod[$this->methodName['sendAudio']] = 'sendAudio';
        if(is_array($audio)) $this->addParams('sendAudio', $this->manageParams($audio, ['audio', 'caption', 'parse_mode', 'duration', 'performer', 'title', 'thumb', 'disable_notification', 'reply_to_message_id']));
        else $this->addParams('sendAudio', [compact('audio', 'caption', 'parse_mode', 'duration', 'performer', 'title', 'thumb', 'disable_notification', 'reply_to_message_id')]);
        $this->currentParams['method'] = 'sendAudio';
        return $this;
    }

    /**
     * Prepare a document.
     * 
     * @link https://core.telegram.org/bots/api#senddocument
     * @param string $document
     * @param string $thumb
     * @param string $caption
     * @param string $parse_mode
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function document($document, $thumb = '', $caption = '', $parse_mode = 'markdown', $disable_notification = false, $reply_to_message_id = null)
    {
        if(!isset($this->apiMethod[$this->methodName['sendDocument']])) $this->apiMethod[$this->methodName['sendDocument']] = 'sendDocument';
        if(is_array($document)) $this->addParams('sendDocument', $this->manageParams($document, ['document', 'thumb', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id']));
        else $this->addParams('sendDocument', [compact('document', 'thumb', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id')]);
        $this->currentParams['method'] = 'sendDocument';
        return $this;
    }

    /**
     * Prepare a video.
     * 
     * @link https://core.telegram.org/bots/api#sendvideo
     * @param string $video
     * @param int $duration
     * @param int $width
     * @param int $height
     * @param string $thumb
     * @param string $caption
     * @param string $parse_mode
     * @param bool $supports_streaming
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function video($video, $duration = null, $width = null, $height = null, $thumb = '', $caption = '', $parse_mode = 'markdown', $supports_streaming = false, $disable_notification = false, $reply_to_message_id = null)
    {
        if(!isset($this->apiMethod[$this->methodName['sendVideo']])) $this->apiMethod[$this->methodName['sendVideo']] = 'sendVideo';
        if(is_array($video)) $this->addParams('sendVideo', $this->manageParams($video, ['video', 'duration', 'width', 'height', 'thumb', 'caption', 'parse_mode', 'supports_streaming', 'disable_notification', 'reply_to_message_id']));
        else $this->addParams('sendVideo', [compact('video', 'duration', 'width', 'height', 'thumb', 'caption', 'parse_mode', 'supports_streaming', 'disable_notification', 'reply_to_message_id')]);
        $this->currentParams['method'] = 'sendVideo';
        return $this;
    }

    /**
     * Prepare an animation.
     * 
     * @link https://core.telegram.org/bots/api#sendanimation
     * @param string $animation
     * @param int $duration
     * @param int $width
     * @param int $height
     * @param string $thumb
     * @param string $caption
     * @param string $parse_mode
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function animation($animation, $duration = null, $width = null, $height = null, $thumb = '', $caption = '', $parse_mode = 'markdown', $disable_notification = false, $reply_to_message_id = null)
    {
        if(!isset($this->apiMethod[$this->methodName['sendAnimation']])) $this->apiMethod[$this->methodName['sendAnimation']] = 'sendAnimation';
        if(is_array($animation)) $this->addParams('sendAnimation', $this->manageParams($animation, ['animation', 'duration', 'width', 'height', 'thumb', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id']));
        else $this->addParams('sendAnimation', [compact('animation', 'duration', 'width', 'height', 'thumb', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id')]);
        $this->currentParams['method'] = 'sendAnimation';
        return $this;
    }

    /**
     * Prepare a poll.
     * 
     * @link https://core.telegram.org/bots/api#sendpoll
     * @param string $question
     * @param array $options
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function poll($question, $options, $disable_notification = false, $reply_to_message_id = null)
    {
        if(!isset($this->apiMethod[$this->methodName['sendPoll']])) $this->apiMethod[$this->methodName['sendPoll']] = 'sendPoll';
        if(is_array($question)) $this->addParams('sendPoll', $this->manageParams($question, ['question', 'options', 'disable_notification', 'reply_to_message_id']));
        else $this->addParams('sendPoll', [compact('question', 'options', 'disable_notification', 'reply_to_message_id')]);
        $this->currentParams['method'] = 'sendPoll';
        return $this;
    }

    /**
     * Prepare a chat action.
     * 
     * @link https://core.telegram.org/bots/api#sendchataction
     * @param string $action
     * @return $this
     */
    public function chatAction($action)
    {
        if(!isset($this->apiMethod[$this->methodName['sendChatAction']])) $this->apiMethod[$this->methodName['sendChatAction']] = 'sendChatAction';
        $this->addParams('sendChatAction', [compact('action')]);
        $this->currentParams['method'] = 'sendChatAction';
        return $this;
    }

    /**
     * Prepare to get user profile's photos.
     * 
     * @link https://core.telegram.org/bots/api#getuserprofilephotos
     * @param int $user_id
     * @param int $offset
     * @param int $limit
     * @return $this
     */
    public function propic($user_id, $offset = null, $limit = null)
    {
        if(!isset($this->apiMethod[$this->methodName['getUserProfilePhotos']])) $this->apiMethod[$this->methodName['getUserProfilePhotos']] = 'getUserProfilePhotos';
        if(is_array($user_id)) $this->addParams('getUserProfilePhotos', $this->manageParams($user_id, ['user_id', 'offset', 'limit']));
        else $this->addParams('getUserProfilePhotos', [compact('user_id', 'offset', 'limit')]);
        $this->currentParams['method'] = 'getUserProfilePhotos';
        return $this;
    }

    /**
     * Prepare to get a file.
     * 
     * @link https://core.telegram.org/bots/api#getfile
     * @param string $file_id
     * @return $this
     */
    public function file($file_id)
    {
        if(!isset($this->apiMethod[$this->methodName['getFile']])) $this->apiMethod[$this->methodName['getFile']] = 'getFile';
        $this->addParams('getFile', [compact('file_id')]);
        $this->currentParams['method'] = 'getFile';
        return $this;
    }

    /**
     * Prepare to kick a member.
     * 
     * @link https://core.telegram.org/bots/api#kickchatmember
     * @param int $user_id
     * @param int $until_date
     * @return $this
     */
    public function kick($user_id, $until_date = null)
    {
        if(!isset($this->apiMethod[$this->methodName['kickChatMember']])) $this->apiMethod[$this->methodName['kickChatMember']] = 'kickChatMember';
        if(is_array($user_id)) $this->addParams('kickChatMember', $this->manageParams($user_id, ['user_id', 'until_date']));
        else $this->addParams('kickChatMember', [compact('user_id', 'until_date')]);
        $this->currentParams['method'] = 'kickChatMember';
        return $this;
    }

    /**
     * Prepare to unban a member.
     * 
     * @link https://core.telegram.org/bots/api#unbanchatmember
     * @param int $user_id
     * @return $this
     */
    public function unban($user_id)
    {
        if(!isset($this->apiMethod[$this->methodName['unbanChatMember']])) $this->apiMethod[$this->methodName['unbanChatMember']] = 'unbanChatMember';
        $this->addParams('unbanChatMember', [compact('user_id')]);
        $this->currentParams['method'] = 'unbanChatMember';
        return $this;
    }

    /**
     * Prepare to restrict a member.
     * 
     * @link https://core.telegram.org/bots/api#restrictchatmember
     * @param int $user_id
     * @param int $until_date
     * @param bool $can_send_messages
     * @param bool $can_send_media_messages
     * @param bool $can_send_other_messages
     * @param bool $can_add_web_page_previews
     * @return $this
     */
    public function restrict($user_id, $until_date = null, $can_send_messages = true, $can_send_media_messages = true, $can_send_other_messages = true, $can_add_web_page_previews = true)
    {
        if(!isset($this->apiMethod[$this->methodName['restrictChatMember']])) $this->apiMethod[$this->methodName['restrictChatMember']] = 'restrictChatMember';
        if(is_array($user_id)) $this->addParams('restrictChatMember', $this->manageParams($user_id, ['user_id', 'until_date', 'can_send_messages', 'can_send_media_messages', 'can_send_other_messages', 'can_add_web_page_previews']));
        else $this->addParams('restrictChatMember', [compact('user_id', 'until_date', 'can_send_messages', 'can_send_media_messages', 'can_send_other_messages', 'can_add_web_page_previews')]);
        $this->currentParams['method'] = 'restrictChatMember';
        return $this;
    }

    /**
     * Prepare to promote a user.
     * 
     * @link https://core.telegram.org/bots/api#promotechatmember
     * @param int $user_id
     * @param bool $can_change_info
     * @param bool $can_post_messages
     * @param bool $can_edit_messages
     * @param bool $can_delete_messages
     * @param bool $can_invite_users
     * @param bool $can_restrict_members
     * @param bool $can_pin_messages
     * @param bool $can_promote_members
     * @return $this
     */
    public function promote($user_id, $can_change_info = false, $can_post_messages = false, $can_edit_messages = false, $can_delete_messages = false, $can_invite_users = false, $can_restrict_members = false, $can_pin_messages = false, $can_promote_members = false)
    {
        if(!isset($this->apiMethod[$this->methodName['promoteChatMember']])) $this->apiMethod[$this->methodName['promoteChatMember']] = 'promoteChatMember';
        if(is_array($user_id)) $this->addParams('promoteChatMember', $this->manageParams($user_id, ['user_id', 'can_change_info', 'can_post_messages', 'can_edit_messages', 'can_delete_messages', 'can_invite_users', 'can_restrict_members', 'can_pin_messages', 'can_promote_members']));
        else $this->addParams('promoteChatMember', [compact('user_id', 'can_change_info', 'can_post_messages', 'can_edit_messages', 'can_delete_messages', 'can_invite_users', 'can_restrict_members', 'can_pin_messages', 'can_promote_members')]);
        $this->currentParams['method'] = 'promoteChatMember';
        return $this;
    }

    /**
     * Prepare to export chat invite link.
     * 
     * @link https://core.telegram.org/bots/api#exportchatinvitelink
     * @return $this
     */
    public function inviteLink()
    {
        if(!isset($this->apiMethod[$this->methodName['exportChatInviteLink']])) $this->apiMethod[$this->methodName['exportChatInviteLink']] = 'exportChatInviteLink';
        return $this;
    }

    /**
     * Prepare to set chat title.
     * 
     * @link https://core.telegram.org/bots/api#setchattitle
     * @param string $title
     * @return $this
     */
    public function chatTitle($title)
    {
        if(!isset($this->apiMethod[$this->methodName['setChatTitle']])) $this->apiMethod[$this->methodName['setChatTitle']] = 'setChatTitle';
        $this->addParams('setChatTitle', [compact('title')]);
        $this->currentParams['method'] = 'setChatTitle';
        return $this;
    }

    /**
     * Prepare to set chat description.
     * 
     * @link https://core.telegram.org/bots/api#setchatdescription
     * @param string $description
     * @return $this
     */
    public function chatDescription($description)
    {
        if(!isset($this->apiMethod[$this->methodName['setChatDescription']])) $this->apiMethod[$this->methodName['setChatDescription']] = 'setChatDescription';
        $this->addParams('setChatDescription', [compact('description')]);
        $this->currentParams['method'] = 'setChatDescription';
        return $this;
    }

    /**
     * Prepare to pin a message.
     * 
     * @link https://core.telegram.org/bots/api#pinchatmessage
     * @param int $message_id
     * @param bool $disable_notification
     * @return $this
     */
    public function pin($message_id, $disable_notification = false)
    {
        if(!isset($this->apiMethod[$this->methodName['pinChatMessage']])) $this->apiMethod[$this->methodName['pinChatMessage']] = 'pinChatMessage';
        if(is_array($message_id)) $this->addParams('pinChatMessage', $this->manageParams($message_id, ['message_id', 'disable_notification']));
        else $this->addParams('pinChatMessage', [compact('message_id', 'disable_notification')]);
        $this->currentParams['method'] = 'pinChatMessage';
        return $this;
    }

    /**
     * Prepare to unpin a message.
     * 
     * @link https://core.telegram.org/bots/api#unpinchatmessage
     * @return $this
     */
    public function unpin()
    {
        if(!isset($this->apiMethod[$this->methodName['unpinChatMessage']])) $this->apiMethod[$this->methodName['unpinChatMessage']] = 'unpinChatMessage';
        return $this;
    }

    /**
     * Prepare to leave a chat.
     * 
     * @link https://core.telegram.org/bots/api#leavechat
     * @return $this
     */
    public function leave()
    {
        if(!isset($this->apiMethod[$this->methodName['leaveChat']])) $this->apiMethod[$this->methodName['leaveChat']] = 'leaveChat';
        return $this;
    }

    /**
     * Prepare to get chat info.
     * 
     * @link https://core.telegram.org/bots/api#getchat
     * @return $this
     */
    public function chatInfo()
    {
        if(!isset($this->apiMethod[$this->methodName['getChat']])) $this->apiMethod[$this->methodName['getChat']] = 'getChat';
        return $this;
    }

    /**
     * Prepare to get chat admins.
     * 
     * @link https://core.telegram.org/bots/api#getchatadministrators
     * @return $this
     */
    public function admins()
    {
        if(!isset($this->apiMethod[$this->methodName['getChatAdministrators']])) $this->apiMethod[$this->methodName['getChatAdministrators']] = 'getChatAdministrators';
        return $this;
    }

    /**
     * Prepare to get chat members' number.
     * 
     * @link https://core.telegram.org/bots/api#getchatmemberscount
     * @return $this
     */
    public function membersCount()
    {
        if(!isset($this->apiMethod[$this->methodName['getChatMembersCount']])) $this->apiMethod[$this->methodName['getChatMembersCount']] = 'getChatMembersCount';
        return $this;
    }

    /**
     * Prepare to get chat member.
     * 
     * @link https://core.telegram.org/bots/api#getchatmember
     * @param int $user_id
     * @return $this
     */
    public function member($user_id)
    {
        if(!isset($this->apiMethod[$this->methodName['getChatMember']])) $this->apiMethod[$this->methodName['getChatMember']] = 'getChatMember';
        $this->addParams('getChatMember', [compact('user_id')]);
        $this->currentParams['method'] = 'getChatMember';
        return $this;
    }

    /**
     * Prepare to set stickers.
     * 
     * @link https://core.telegram.org/bots/api#setchatstickerset
     * @param string $sticker_set_name
     * @return $this
     */
    public function setSticker($sticker_set_name)
    {
        if(!isset($this->apiMethod[$this->methodName['setChatStickerSet']])) $this->apiMethod[$this->methodName['setChatStickerSet']] = 'setChatStickerSet';
        $this->addParams('setChatStickerSet', [compact('sticker_set_name')]);
        $this->currentParams['method'] = 'setChatStickerSet';
        return $this;
    }

    /**
     * Prepare to delete stickers.
     * 
     * @link https://core.telegram.org/bots/api#deletechatstickerset
     * @return $this
     */
    public function deleteSticker()
    {
        if(!isset($this->apiMethod[$this->methodName['deleteChatStickerSet']])) $this->apiMethod[$this->methodName['deleteChatStickerSet']] = 'deleteChatStickerSet';
        return $this;
    }

    /**
     * Prepare a callback query.
     * 
     * @link
     * @param string $text
     * @param bool $show_alert
     * @param string $url
     * @param int $cache_time
     * @return $this
     */
    public function callbackQuery($text = '', $show_alert = false, $url = '', $cache_time = 0)
    {
        if(!isset($this->apiMethod[$this->methodName['answerCallbackQuery']])) $this->apiMethod[$this->methodName['answerCallbackQuery']] = 'answerCallbackQuery';
        if(is_array($text)) $this->addParams('answerCallbackQuery', $this->manageParams($text, ['text', 'show_alert', 'url', 'cache_time']));
        else $this->addParams('answerCallbackQuery', [compact('text', 'show_alert', 'url', 'cache_time')]);
        $this->currentParams['method'] = 'answerCallbackQuery';
        return $this;
    }

    /**
     * Attach custom keyboard.
     * 
     * @param array $keyboard
     * @return $this
     */
    public function withKeyboard($keyboard)
    {
        foreach($this->currentParams['chat'] as $chat) {
            for($i = $this->currentParams['index'][$chat]['start']; $i < $this->currentParams['index'][$chat]['end']; $i++) {
                $this->params[$this->currentParams['method']][$chat][$i]['reply_markup'] = json_encode($keyboard);
            }
        }
        return $this;
    }

    /**
     * Attach force reply event.
     * 
     * @link https://core.telegram.org/bots/api#forcereply
     * @param bool $selective
     * @return $this
     */
    public function withForceReply($selective = false)
    {
        $force_reply = true;
        foreach($this->currentParams['chat'] as $chat) {
            for($i = $this->currentParams['index'][$chat]['start']; $i < $this->currentParams['index'][$chat]['end']; $i++) {
                $this->params[$this->currentParams['method']][$chat][$i]['reply_markup'] = json_encode(compact('force_reply', 'selective'));
            }
        }
        return $this;
    }

    /**
     * Attach remove keyboard event.
     * 
     * @link https://core.telegram.org/bots/api#replykeyboardremove
     * @param bool $selective
     * @return $this
     */
    public function withKeyboardRemove($selective = false)
    {
        $remove_keyboard = true;
        foreach($this->currentParams['chat'] as $chat) {
            for($i = $this->currentParams['index'][$chat]['start']; $i < $this->currentParams['index'][$chat]['end']; $i++) {
                $this->params[$this->currentParams['method']][$chat][$i]['reply_markup'] = json_encode(compact('remove_keyboard', 'selective'));
            }
        }
        return $this;
    }

    /**
     * Get request result.
     * 
     * @param string|int $chat
     * @param string $method
     * @return array
     */
    public function getResult($chat = null, $method = null)
    {
        if(!empty($chat)) {
            if(isset($this->chat[$chat])) $chat = 'chat' . $this->chat[$chat];
            else $chat = 'chat' . $chat;
        }
        return empty($chat) ? $this->result : (empty($method) ? $this->result[$chat] : $this->result[$chat][$method]);
    }

    /**
     * Get request link.
     * 
     * @param string|int $chat
     * @param string $method
     * @return array
     */
    public function getRequest($chat = null, $method = null)
    {
        $request = json_decode(preg_replace('/bot.*?\//', 'botTOKEN\/',  json_encode($this->request)), true);
        if(!empty($chat)) {
            if(isset($this->chat[$chat])) $chat = 'chat' . $this->chat[$chat];
            else $chat = 'chat' . $chat;
        }
        return empty($chat) ? $request : (empty($method) ? $request[$chat] : $request[$chat][$method]);
    }

    /**
     * Get request success.
     * 
     * @param string|int $chat
     * @param string $method
     * @return array
     */
    public function getSuccess($chat = null, $method = null)
    {
        if(!empty($chat)) {
            if(isset($this->chat[$chat])) $chat = 'chat' . $this->chat[$chat];
            else $chat = 'chat' . $chat;
        }
        return empty($chat) ? $this->success : (empty($method) ? $this->success[$chat] : $this->success[$chat][$method]);
    }
}
