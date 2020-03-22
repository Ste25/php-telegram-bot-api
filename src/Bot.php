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
     * @param bool $select
     * @return $this
     */
    public function addChat($chat, $select = false)
    {
        if(!is_array($chat)) $chat = func_get_args();
        if(end($chat) === false || end($chat) === true) array_pop($chat);
        $this->chat = array_unique(array_merge($this->chat, $chat));
        if($select) $this->selectChat($chat);
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
        if($chat === 'all') $this->currentParams['chat'][] = 'all';
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
        if(!isset($this->apiMethod['getMe'])) $this->apiMethod['getMe'] = 'getMe';
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
        $this->setParams(func_get_args(), $this->setApi('sendMessage', ['text', 'parse_mode', 'disable_web_page_preview', 'disable_notification', 'reply_to_message_id']));
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
        $this->setParams(func_get_args(), $this->setApi('forwardMessage', ['from_chat_id', 'message_id', 'disable_notification']));
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
        $this->setParams(func_get_args(), $this->setApi('sendPhoto', ['photo', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id']));
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
        $this->setParams(func_get_args(), $this->setApi('sendAudio', ['audio', 'caption', 'parse_mode', 'duration', 'performer', 'title', 'thumb', 'disable_notification', 'reply_to_message_id']));
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
        $this->setParams(func_get_args(), $this->setApi('sendDocument', ['document', 'thumb', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id']));
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
        $this->setParams(func_get_args(), $this->setApi('sendVideo', ['video', 'duration', 'width', 'height', 'thumb', 'caption', 'parse_mode', 'supports_streaming', 'disable_notification', 'reply_to_message_id']));
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
        $this->setParams(func_get_args(), $this->setApi('sendAnimation', ['animation', 'duration', 'width', 'height', 'thumb', 'caption', 'parse_mode', 'disable_notification', 'reply_to_message_id']));
        return $this;
    }

    /**
     * Prepare a poll.
     * 
     * @link https://core.telegram.org/bots/api#sendpoll
     * @param string $question
     * @param string $options
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function poll($question, $options = null, $disable_notification = false, $reply_to_message_id = null)
    {
        $this->setParams(func_get_args(), $this->setApi('sendPoll', ['question', 'options', 'disable_notification', 'reply_to_message_id']));
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
        $this->setParams(func_get_args(), $this->setApi('sendChatAction', ['action']));
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
        $this->setParams(func_get_args(), $this->setApi('getUserProfilePhotos', ['user_id', 'offset', 'limit']));
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
        $this->setParams(func_get_args(), $this->setApi('getFile', ['file_id']));
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
        $this->setParams(func_get_args(), $this->setApi('kickChatMember', ['user_id', 'until_date']));
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
        $this->setParams(func_get_args(), $this->setApi('unbanChatMember', ['user_id']));
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
        $this->setParams(func_get_args(), $this->setApi('restrictChatMember', ['user_id', 'until_date', 'can_send_messages', 'can_send_media_messages', 'can_send_other_messages', 'can_add_web_page_previews']));
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
        $this->setParams(func_get_args(), $this->setApi('promoteChatMember', ['user_id', 'can_change_info', 'can_post_messages', 'can_edit_messages', 'can_delete_messages', 'can_invite_users', 'can_restrict_members', 'can_pin_messages', 'can_promote_members']));
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
        if(!isset($this->apiMethod['exportChatInviteLink'])) $this->apiMethod['exportChatInviteLink'] = 'exportChatInviteLink';
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
        $this->setParams(func_get_args(), $this->setApi('setChatTitle', ['title']));
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
        $this->setParams(func_get_args(), $this->setApi('setChatDescription', ['description']));
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
        $this->setParams(func_get_args(), $this->setApi('pinChatMessage', ['message_id', 'disable_notification']));
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
        if(!isset($this->apiMethod['unpinChatMessage'])) $this->apiMethod['unpinChatMessage'] = 'unpinChatMessage';
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
        if(!isset($this->apiMethod['leaveChat'])) $this->apiMethod['leaveChat'] = 'leaveChat';
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
        if(!isset($this->apiMethod['getChat'])) $this->apiMethod['getChat'] = 'getChat';
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
        if(!isset($this->apiMethod['getChatAdministrators'])) $this->apiMethod['getChatAdministrators'] = 'getChatAdministrators';
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
        if(!isset($this->apiMethod['getChatMembersCount'])) $this->apiMethod['getChatMembersCount'] = 'getChatMembersCount';
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
        $this->setParams(func_get_args(), $this->setApi('getChatMember', ['user_id']));
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
        $this->setParams(func_get_args(), $this->setApi('setChatStickerSet', ['sticker_set_name', 'disable_notification']));
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
        if(!isset($this->apiMethod['deleteChatStickerSet'])) $this->apiMethod['deleteChatStickerSet'] = 'deleteChatStickerSet';
        return $this;
    }

    /**
     * Prepare a callback query.
     * 
     * @link https://core.telegram.org/bots/api#answercallbackquery
     * @param string|int $callback_query_id
     * @param string $text
     * @param bool $show_alert
     * @param string $url
     * @param int $cache_time
     * @return $this
     */
    public function callbackQuery($callback_query_id, $text = '', $show_alert = false, $url = '', $cache_time = 0)
    {
        $this->setParams(func_get_args(), $this->setApi('answerCallbackQuery', ['callback_query_id', 'text', 'show_alert', 'url', 'cache_time']));
        return $this;
    }

    /**
     * Prepare to edit a message's text.
     * 
     * @link https://core.telegram.org/bots/api#editmessagetext
     * @param int $message_id
     * @param string $inline_message_id
     * @param string $text
     * @param string $parse_mode
     * @param bool $disable_web_page_preview
     * @param string $reply_markup
     * @return $this
     */
    public function editText($message_id, $inline_message_id = '', $text = '', $parse_mode = 'markdown', $disable_web_page_preview = false, $reply_markup = null)
    {
        $this->setParams(func_get_args(), $this->setApi('editMessageText', ['message_id', 'inline_message_id', 'text', 'parse_mode', 'disable_web_page_preview', 'reply_markup']));
        return $this;
    }

    /**
     * Prepare to edit a message's caption.
     * 
     * @link https://core.telegram.org/bots/api#editmessagecaption
     * @param int $message_id
     * @param string $inline_message_id
     * @param string $caption
     * @param string $parse_mode
     * @param string $reply_markup
     * @return $this
     */
    public function editCaption($message_id, $inline_message_id = '', $caption = '', $parse_mode = 'markdown', $reply_markup = null)
    {
        $this->setParams(func_get_args(), $this->setApi('editMessageCaption', ['message_id', 'inline_message_id', 'caption', 'parse_mode', 'reply_markup']));
        return $this;
    }

    /**
     * Prepare to edit a message's media.
     * 
     * @link https://core.telegram.org/bots/api#editmessagemedia
     * @param int $message_id
     * @param string $inline_message_id
     * @param string $media
     * @param string $reply_markup
     * @return $this
     */
    public function editMedia($message_id, $inline_message_id = '', $media = '', $reply_markup = null)
    {
        $this->setParams(func_get_args(), $this->setApi('editMessageMedia', ['message_id', 'inline_message_id', 'media', 'reply_markup']));
        return $this;
    }

    /**
     * Prepare to edit a message's reply markup.
     * 
     * @link https://core.telegram.org/bots/api#editmessagereplymarkup
     * @param int $message_id
     * @param string $inline_message_id
     * @param string $reply_markup
     * @return $this
     */
    public function editMarkup($message_id, $inline_message_id = '', $reply_markup = null)
    {
        $this->setParams(func_get_args(), $this->setApi('editMessageReplyMarkup', ['message_id', 'inline_message_id', 'reply_markup']));
        return $this;
    }

    /**
     * Prepare to stop a poll.
     * 
     * @link https://core.telegram.org/bots/api#stoppoll
     * @param int $message_id
     * @return $this
     */
    public function stopPoll($message_id)
    {
        $this->setParams(func_get_args(), $this->setApi('stopPoll', ['message_id']));
        return $this;
    }

    /**
     * Prepare to delete a message.
     * 
     * @link https://core.telegram.org/bots/api#deletemessage
     * @param int $message_id
     * @return $this
     */
    public function deleteMessage($message_id)
    {
        $this->setParams(func_get_args(), $this->setApi('deleteMessage', ['message_id']));
        return $this;
    }

    /**
     * Prepare a sticker.
     * 
     * @link https://core.telegram.org/bots/api#sendsticker
     * @param string|array $sticker
     * @param bool $disable_notification
     * @param int $reply_to_message_id
     * @return $this
     */
    public function sticker($sticker, $disable_notification = false, $reply_to_message_id = null)
    {
        $this->setParams(func_get_args(), $this->setApi('sendSticker', ['sticker', 'disable_notification', 'reply_to_message_id']));
        return $this;
    }

    /**
     * Prepare to get a sticker set.
     * 
     * @link https://core.telegram.org/bots/api#getstickerset
     * @param string|array $name
     * @return $this
     */
    public function getStickerSet($name)
    {
        $this->setParams(func_get_args(), $this->setApi('getStickerSet', ['name']));
        return $this;
    }

    /**
     * Prepare an inline query.
     * 
     * @link https://core.telegram.org/bots/api#answerinlinequery
     * 
     * @param string $text
     * @param bool $show_alert
     * @param string $url
     * @param int $cache_time
     * @return $this
     */
    public function inlineQuery($inline_query_id, $results = [], $cache_time = 0, $is_personal = false, $next_offset = '', $switch_pm_text = '', $switch_pm_parameter = '')
    {
        $this->setParams(func_get_args(), $this->setApi('answerInlineQuery', ['inline_query_id', 'results', 'cache_time', 'is_personal', 'next_offset', 'switch_pm_text', 'switch_pm_parameter']));
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
            for($i = $this->currentParams['index']['chat' . $chat]['start']; $i < $this->currentParams['index']['chat' . $chat]['end']; $i++) {
                $this->params[$this->currentParams['method']]['chat' . $chat][$i]['reply_markup'] = json_encode($keyboard);
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
            for($i = $this->currentParams['index']['chat' . $chat]['start']; $i < $this->currentParams['index']['chat' . $chat]['end']; $i++) {
                $this->params[$this->currentParams['method']]['chat' . $chat][$i]['reply_markup'] = json_encode(compact('force_reply', 'selective'));
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
            for($i = $this->currentParams['index']['chat' . $chat]['start']; $i < $this->currentParams['index']['chat' . $chat]['end']; $i++) {
                $this->params[$this->currentParams['method']]['chat' . $chat][$i]['reply_markup'] = json_encode(compact('remove_keyboard', 'selective'));
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
        if($chat !== null) {
            if(isset($this->chat[$chat]) && !is_numeric($chat)) $chat = 'chat' . $this->chat[$chat];
            else $chat = 'chat' . $chat;
        }
        return $chat === null ? $this->result : (isset($this->result[$chat]) ? (empty($method) ? $this->result[$chat] : (isset($this->result[$chat][$method]) ? $this->result[$chat][$method] : false)) : false);
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
        if($chat !== null) {
            if(isset($this->chat[$chat]) && !is_numeric($chat)) $chat = 'chat' . $this->chat[$chat];
            else $chat = 'chat' . $chat;
        }
        return $chat === null ? $request : (isset($request[$chat]) ? (empty($method) ? $request[$chat] : (isset($request[$chat][$method]) ? $request[$chat][$method] : false)) : false);
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
        if($chat !== null) {
            if(isset($this->chat[$chat]) && !is_numeric($chat)) $chat = 'chat' . $this->chat[$chat];
            else $chat = 'chat' . $chat;
        }
        return $chat === null ? $this->success : (isset($this->success[$chat]) ? (empty($method) ? $this->success[$chat] : (isset($this->success[$chat][$method]) ? $this->success[$chat][$method] : false)) : false);
    }
}
