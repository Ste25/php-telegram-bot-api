<?php

namespace ste25\Telegram;

use ste25\Telegram\Core;

/**
 * Keyboard class.
 * 
 * @author https://github.com/Ste25
 */
class Keyboard extends Core
{
    /**
     * Set keyboard's type.
     * 
     * @param string $type
     * @return $this
     */
    public function keyboard($type = 'inline_keyboard')
    {
        $this->keyboardOptions['type'] = $type;
        return $this;
    }

    /**
     * Create a keyboard's row.
     * 
     * @return $this
     */
    public function row()
    {
        $this->keyboardOptions['currentRow'] = count($this->keyboardOptions['rows']) + 1;
        return $this;
    }

    /**
     * Select a custom row.
     * 
     * @param int $rowNum
     * @return $this
     */
    public function selectRow($rowNum)
    {
        if(isset($this->keyboardOptions['rows'][$rowNum-1])) $this->keyboardOptions['currentRow'] = $rowNum;
        return $this;
    }

    /**
     * Create an inline keyboard's button.
     * 
     * @link https://core.telegram.org/bots/api#inlinekeyboardbutton
     * @param string $text
     * @param string $url
     * @param string $callback_data
     * @param string $switch_inline_query
     * @param string $switch_inline_query_current_chat
     * @param CallbackGame $callback_game
     * @param bool $pay
     * @return $this
     */
    public function inlineButtons($text, $url = '', $callback_data = '', $switch_inline_query = '', $switch_inline_query_current_chat = '', $callback_game = null, $pay = false)
    {        
        if(is_array($text)) $this->keyboardOptions['buttonList'] = array_merge($this->keyboardOptions['buttonList'], $this->manageParams($text, ['text', 'url', 'callback_data', 'switch_inline_query', 'switch_inline_query_current_chat', 'callback_game', 'pay']));
        else $this->keyboardOptions['buttonList'] = array_merge($this->keyboardOptions['buttonList'], [compact('text', 'url', 'callback_data', 'switch_inline_query', 'switch_inline_query_current_chat', 'callback_game', 'pay')]);
        return $this;
    }

    /**
     * Create an reply keyboard's button.
     * 
     * @link https://core.telegram.org/bots/api#keyboardbutton
     * @param string $text
     * @param bool $request_contact
     * @param bool $request_location
     * @return $this
     */
    public function replyButtons($text, $request_contact = false, $request_location = false) {
        if(is_array($text)) $this->keyboardOptions['buttonList'] = array_merge($this->keyboardOptions['buttonList'], $this->manageParams($text, ['text', 'request_contact', 'request_location']));
        else $this->keyboardOptions['buttonList'] = array_merge($this->keyboardOptions['buttonList'], [compact('text', 'request_contact', 'request_location')]);
        return $this;
    }

    /**
     * Insert buttons in current row.
     * 
     * @return $this
     */
    public function insert()
    {
        $this->keyboardOptions['rows'][$this->keyboardOptions['currentRow'] - 1] = array();
        foreach($this->keyboardOptions['buttonList'] as $button) {
            $this->keyboardOptions['rows'][$this->keyboardOptions['currentRow'] - 1][] = $button;
        }
        $this->keyboardOptions['buttonList'] = array();
        return $this;
    }

    /**
     * Add buttons after row has been created and populated.
     * 
     * @param int|string $position
     * @return $this
     */
    public function addButtons($position = 'end')
    {
        if($position === 'start') $position = 0;
        else if($position === 'end') $position = count($this->keyboardOptions['rows'][$this->keyboardOptions['currentRow'] - 1]);
        array_splice($this->keyboardOptions['rows'][$this->keyboardOptions['currentRow'] - 1], $position, 0, $this->keyboardOptions['buttonList']);
        $this->keyboardOptions['buttonList'] = array();
        return $this;
    }

    /**
     * Insert buttons following the given schema.
     * 
     * @param array $rows
     * @return $this
     */
    public function fromButtons($rows = array())
    {
        if(!empty($rows)) {
            $i = 0;
            while(count($this->keyboardOptions['buttonList'])) {
                if(!isset($rows[$i])) break;
                $this->keyboardOptions['rows'][] = array_splice($this->keyboardOptions['buttonList'], 0, $rows[$i]);
                $i++;
            }
        }
        else $this->keyboardOptions['rows'][] = $this->keyboardOptions['buttonList'];
        $this->keyboardOptions['currentRow'] = count($this->keyboardOptions['rows']);
        $this->keyboardOptions['buttonList'] = array();
        return $this;
    }

    /**
     * Create new keyboard.
     * 
     * @link https://core.telegram.org/bots/api#replykeyboardmarkup and https://core.telegram.org/bots/api#inlinekeyboardmarkup
     * @param bool $resize_keyboard
     * @param bool $one_time_keyboard
     * @param bool $selective
     * @return string
     */
    public function create($resize_keyboard = false, $one_time_keyboard = false, $selective = false)
    {
        $return = [
            $this->keyboardOptions['type'] => $this->keyboardOptions['rows']
        ];
        if($this->keyboardOptions['type'] === 'keyboard') {
            $return['resize_keyboard'] = $resize_keyboard;
            $return['one_time_keyboard'] = $one_time_keyboard;
            $return['selective'] = $selective;
        }
        $this->keyboardOptions['currentRow'] = 1;
        $this->keyboardOptions['rows'] = array();
        return $return;
    }

    /**
     * Get keyboard's buttons.
     * 
     * @param array $keyboard
     * @return array
     */
    public function getButtons($keyboard)
    {
        $keyboard = $keyboard[array_keys($keyboard)[0]];
        foreach($keyboard as $row) {
            foreach($row as $single) {
                $buttons[] = $single;
            }
        }
        return $buttons;
    }
}
