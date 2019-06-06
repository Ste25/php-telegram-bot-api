# Simple PHP Telegram Bot Api
### Easy to use - especially for beginners
[![API Version](https://img.shields.io/badge/Telegram%20Bot%20API-May%2031%2C%202019-blue.svg)](https://core.telegram.org/bots/api) [![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%205.5-8892bf.svg)](https://www.php.net) [![Tested](https://img.shields.io/badge/Tested%20On-PHP%207-green.svg)](https://www.php.net/manual/en/migration70.new-features.php) [![cURL](https://img.shields.io/badge/cURL-enabled-%23d65cad.svg)](https://www.php.net/manual/en/book.curl.php) [![License](https://img.shields.io/badge/License-MIT-%23e65c00.svg)](LICENSE)

Languages: [English](#english) - [Italiano](#italiano)
## English
### Table of Contents
1. [An introduction to Telegram's bots](#an-introduction-to-telegrams-bots)
2. [My first bot](#my-first-bot)
3. [Requirements](#requirements)
4. [Download](#download)
5. [The bases](#the-bases)
6. [Initialize](#initialize)
7. [Available methods](#available-methods)
8. [Set one or more chat(s)](#set-one-or-more-chats)
    - [First chat(s)](#first-chats)
    - [Add one or more chat(s)](#add-one-or-more-chats)
    - [Remove one or more chat(s)](#remove-one-or-more-chats)
    - [Select one or more chat(s)](#select-one-or-more-chats)
9. [Run methods](#run-methods)
10. [Reply Markup](#reply-markup)
    - [Set a keyboard](#set-a-keyboard)
    - [Alternative approach to Reply Markup](#alternative-approach-to-reply-markup)
    - [Add buttons](#add-buttons)
    - [Reply Keyboard: an example](#reply-keyboard-an-example)
    - [Attach a Keyboard](#attach-a-keyboard)
    - [Force Reply and Keyboard Remove](#force-reply-and-keyboard-remove)
11. [Run prepared methods](#run-prepared-methods)
12. [Get Telegram's responses](#get-telegrams-responses)
### An introduction to Telegram's bots
'Bots are third-party applications that run inside Telegram.' A bot can perform different tasks: chat, send photos, video, documents, audio, kick, ban, restrict, promote users, pin messages, change channels' and groups' information, draw up stats and so on... You may check the [Official Site](https://core.telegram.org/bots) for a more detailed description of what bots can and cannot do.
### My first bot
Create a Telegram's bot is really simple: you have to talk to [Bot Father](https://t.me/BotFather) and follow his instructions (see [How do I create a bot?](https://core.telegram.org/bots/#3-how-do-i-create-a-bot)). The most important info given by [Bot Father](https://t.me/BotFather) is an alphanumerical string called _**token**_ that allows you to tell your bot what to do.

After obtaining your _token_ you can start using this library which simply further the creation of **PHP code** required by bots.
### Requirements
In addition to your _token_ you'll need:
* PHP >= 5.5
* `cURL` enabled
### Download
You can require this library via **composer**:
```
composer require ste25/php-telegram-bot-api dev-master@dev
```
### The bases
This library's purpose is to simply dev's work.

The fundamental logic is the following: **_Init the library_ -> _Set chats_ -> _Create your contents_ -> _Execute and send_ -> _Check responses (optional)_**
### Initialize
You can create a new _bot_ running the following code:
```php
<?php
require_once 'vendor/autoload.php'; //or your path to composer's autoload.

use ste25\Telegram\Bot;

$bot = new Bot('TOKEN');
```
You have to replace the word _TOKEN_ with your actual _token_.
### Available methods
The methods described by [the Official Telegram's API](https://core.telegram.org/bots/api#available-methods) availables are:

|Method               |Function's name  |
|-----                |-------------    |
|getMe                |test             |
|sendMessage          |message          |
|forwardMessage       |forward          |
|sendPhoto            |photo            |
|sendAudio            |audio            |
|sendDocument         |document         |
|sendVideo            |video            |
|sendAnimation        |animation        |
|sendPoll             |poll             |
|sendChatAction       |cahtAction       |
|getUserProfilePhotos |propic           |
|getFile              |file             |
|kickChatMember       |kick             |
|unbanChatMember      |unban            |
|restrictChatMember   |restrict         |
|promoteChatMember    |promote          |
|exportChatInviteLink |inviteLink       |
|setChatTitle         |chatTitle        |
|setChatDescription   |chatDescription  |
|pinChatMessage       |pin              |
|unpinChatMessage     |unpin            |
|leaveChat            |leave            |
|getChat              |chatInfo         |
|getChatAdministrators|admins           |
|getChatMembersCount  |membersCount     |
|getChatMember        |member           |
|setChatStickerSet    |setSticker       |
|deleteChatStickerSet |deleteSticker    |
|answerCallbackQuery  |callbackQuery    |
### Set one or more chat(s)
Almost all Telegram's methods require a **chat ID**, an integer (or a string) that identify users, groups and channels. This library allow you to **set one or more IDs only _one_ time**.
### First chat(s)
The most important function to correctly manage chats is `chat`. This function's purpose is to set **one or more chats**:
```php
$bot->chat('first_id', 'second_id', 'third_id', 'etc...');
```
It's possible to use an **array to give each chat a _name_** in order to recall that chat later (see [`selectChat`]()].
```php
$bot->chat(['Sheldon' => 'first_id', 'Leonard' => 'second_id', 'Howard' => 'third_id', 'Etc...' => 'etc...]);
```
**You do _not_ have to use `chat` before _every_ method**, you can set your chats at the top of the code **only once**!

If you call the function `chat` more than once, the previously chats will be overwritten.
#### Add one or more chat(s)
You can _add_ chats using `addChat`:
```php
$bot->addChat('fourth_chat', 'fifth_chat', 'sixth_chat', 'etc...');
```
It's possible to use an array (same as `chat`):
```php
$bot->addChat(['Amy' => 'fourth_chat', 'Penny' => 'fifth_chat', 'Bernadette' => 'sixth_chat', 'Etc...' => 'etc...]);
```
#### Remove one or more chat(s)
You can _remove_ chats using `removeChat`:
```php
$bot->removeChat('first_chat', 'fifth_chat', 'etc...');
```
Or with the **names** given previously:
```php
$bot->removeChat('Sheldon', 'Penny', 'etc...');
```
You can also use an array:
```php
$bot->removeChat(['Sheldon', 'Penny', 'etc...']);
```
#### Select one or more chat(s)
Every method like message, photo, video (etc...) prepares its content to be sent to **every** chat. You can **change** this behaviour by selecting one or more chats with `selectChat` **before** calling the method itself:
```php
$bot->selectChat('chat_id');
```
Or with the **names** given previously:
```php
$bot->selectChat('Leonard'); //Leonard's chat_id was added previously.
```
**Multiple selection**:
```php
$bot->selectChat('Sheldon', 'Leonard'); //Sheldon's and Leonard's chat_id were added previously.
```
You can also use an array:
```php
$bot->selectChat(['Sheldon', 'Leonard']); //Sheldon's and Leonard's chat_id were added previously.
```
If you want to select **all** the chats you added, you may use the same function with no arguments:
```php
$bot->selectChat(); //Select all chat.
```
**_Be careful!_** It's **not** possible to **select one chat that wasn't added via `chat`**! That is: **every chat must be specified via `chat`**.
### Run methods
This library use Telegram's API's methods in a simple, more effective way. Besides chat IDs and _reply_markup_ (see [Reply Markup]()), **every argument has the name and follow the order specified by [the Official API](https://core.telegram.org/bots/api#available-methods)**.

Let's see how to use `message`.

You can **prepare one message** using the following code:
```php
$bot->message($text, $parse_mode = 'markdown', $disable_web_page_preview = false, $disable_notification = false, $reply_to_message_id = null); //Arguments' name and order follow the official API!
```
Obviously `$text` parameter doesn't have a default value. You can see which parameter are required by every method reading Telegram's API.

**Use an array to choose which argument you're going to set**:
```php
$bot->message(['text' => 'First message!', 'disable_notification' => true]); //Prepare a message with content "First message!" and disable_notification set to true 
```
Other parameters will be set by Telegram itself.

It's possible to **prepare more messages** within the same call:
```php
$bot->message([['First message!'], ['Second message'], ['Third message']]); //Prepare three messages
```
Or use an array of arrays:
```php
$bot->message([['text' => 'First message!', 'disable_notification' => true], ['text' => '<b>Second message</b>', 'parse_mode' => 'html]]); //Prepare two messages
```
**Prepare _different_ messages for _different_ chats**:
```php
$bot->selectChat('Howard', 'Bernadette')->message('To Howard and Bernadette!')->selectChat('Sheldon')->message('To Sheldon');
```
Prepare different messages for different chats **and messages for all**:
```php
$bot->message('Message to all people!')->selectChat('Howard', 'Bernadette')->message('To Howard and Bernadette!')->selectChat('Sheldon')->message('To Sheldon');
```
**Combine more methods** there is no limit to your imagination:
```php
$bot->message('Message to all people!')->selectChat('Penny')->photo('Photo to Penny')->selectChat()->video('Video to all!');
```
### Reply Markup
_Reply Markups_ are always the most difficult elements to understand, so we tried to simplify them as much as possible.
#### Set a keyboard
You can set a **keyboard** using `keyboard` and passing as argument its type: _keyboard_ or _inline_keyboard_ (default).
```php
$keyboard = $bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']])->fromButtons([2, 1])->create();
```
This code will create a keyboard with three buttons (and links): two in the first row, one in the second.

**Note:** `$keyboard`'s `var_dump` will be:
```php
array(1) {
  ["inline_keyboard"]=>
  array(2) {
    [0]=>
    array(2) {
      [0]=>
      array(2) {
        ["text"]=>
        string(5) "text1"
        ["url"]=>
        string(19) "https://example1.it"
      }
      [1]=>
      array(2) {
        ["text"]=>
        string(5) "text2"
        ["url"]=>
        string(19) "https://example2.it"
      }
    }
    [1]=>
    array(1) {
      [0]=>
      array(2) {
        ["text"]=>
        string(5) "text3"
        ["url"]=>
        string(19) "https://example3.it"
      }
    }
  }
}
```
Let's see each method in details.

The function `keyboard` specifies which keyboard you are gong to create:
```php
$bot->keyboard('inline_keyboard'); //or simply $bot->keyboard();
```
You can create inline buttons with `inlineButtons` and reply buttons with (let's see... oh yes!) `replyButtons`. Their parameters follow the name and the order specified by [the Official API](https://core.telegram.org/bots/api#inlinekeyboardbutton).
```php
$bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']]);
```
You can always use an array of associative arrays:
```php
$bot->keyboard()->inlineButtons([['text' => 'text1', 'url' => 'https://example1.it'], ['text' => 'text2', 'callback_data' => 'my_data']]);
```
If you need only **one** button, you may use the simpler version:
```php
$bot->keyboard()->inlineButtons($text, $url = '', $callback_data = '', $switch_inline_query = '', $switch_inline_query_current_chat = '', $callback_game = null, $pay = false);
```
Or an associative array:
```php
$bot->keyboard()->inlineButtons(['text' => 'content', 'pay' => true]);
```
The function `fromButtons` allows you to specify rows and buttons per row through an array: the first element in the array stands for the number of buttons in the first row, the second element stands for the number of buttons in the second row and so on...
```php
$keyboard = $bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']])->fromButtons([2, 1]);
```
The function `create` returns an array (that is the keyboard itself) and clear the other parameters so that the class is ready for a new keyboard. This function accepts **arguments only in case of reply keyboards**: in order these parameters are _resize_keyboard_ (default false), _one_time_keyboard_ (default false), _selective_ (default false).
```php
$keyboard = $bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']])->fromButtons([2, 1])->create();
```
#### Alternative approach to Reply Markup
There is another way to create a keyboard:
```php
$keyboard = $bot->keyboard()->inlineButtons('button 1', 'https://example1.com')->insert()->row()->inlineButtons([['button 2', 'https://example2.com'], ['button 3', 'https://example3.com']])->insert()->create();
```
With this code, you can generate the keyboard **line by line**.

With `insert` you can add the buttons created with `inlineButtons` and clear the list, the function `row` create a new row. **The last method will always be `create`**.
#### Add buttons
**Call this function _before_ `create`!**

Sometimes you want to start creating a keyboard and later add some buttons. It's really simple: first of all you have to **create buttons** with `inlineButtons` or `replyButtons`, then **select the row** by calling `selectRow`:
```php
$bot->selectRow(1);
```
Eventually **insert the buttons** by calling `addButtons`:
```php
$bot->selectRow(1)->addButtons('end');
```
This function accepts an argument which indicate the position where the buttons will be appended. This argument can be an integer or one of the two keywords _start_ and _end_.
#### Reply Keyboard: an example
```php
$keyboard = $bot->keyboard('keyboard')->replyButtons([['First'], ['Second'], ['Third']])->fromButtons([1, 2])->create($resize_keyboard = false, $one_time_keyboard = false, $selective = false);
```
**Note:** `$keyboard`'s `var_dump` will print:
```php
array(4) {
  ["keyboard"]=>
  array(2) {
    [0]=>
    array(1) {
      [0]=>
      array(1) {
        ["text"]=>
        string(5) "First"
      }
    }
    [1]=>
    array(2) {
      [0]=>
      array(1) {
        ["text"]=>
        string(6) "Second"
      }
      [1]=>
      array(1) {
        ["text"]=>
        string(5) "Third"
      }
    }
  }
  ["resize_keyboard"]=>
  bool(false)
  ["one_time_keyboard"]=>
  bool(false)
  ["selective"]=>
  bool(false)
}
```
#### Attach a Keyboard
After creating a keyboard, you may want to attach it to one method that supports it (see the [Official API](https://core.telegram.org/bots/api#available-methods)). This can be done thanks to `withKeyboard`:
```php
$keyboard = $bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']])->fromButtons([2, 1])->create();

$bot->message('Message with keyboard!')->withKeyboard($keyboard);
```
#### Force Reply and Keyboard Remove
You can use _Force Reply_ and _Keyboard Remove_ thanks to `withForceReply` and `withKeyboardRemove`:
```php
$bot->message('Message with Force Reply!')->withForceReply($selective = false);
```
```php
$bot->message('Message with Keyboard Remove!')->withKeyboardRemove($selective = false);
```
### Run prepared methods
To run all prepared methods you may use the function `send`:
```php
$bot->message('Message to all people!')->selectChat('Penny')->photo('Photo to Penny')->selectChat()->video('Video to all!')->send();
```
### Get Telegram's responses
After running `send`, you can check the status of your requests thanks to `getSuccess`:
```php
$successList = $bot->getSuccess();
```
This function returns an array with all methods and chats (in the format _chatID_) with a boolean value: true for success, false for failure:
```php
array(2) {
  ["chatID1"]=> //ID1 => id chat one
  array(1) {
    ["message"]=>
    array(1) {
      [0]=>
      bool(true)
    }
  }
  ["chatID2"]=> //ID2 => id chat two
  array(1) {
    ["message"]=>
    array(2) {
      [0]=>
      bool(true)
      [1]=>
      bool(true)
    }
  }
}
```
If you want to get Telegram's info, you may use `getResult`:
```php
$resultList = $bot->getResult();
```
That returns an array:
```php
array(2) {
  ["chatID1"]=> //ID1 => id chat one
  array(1) {
    ["message"]=>
    array(1) {
      [0]=>
      //Telegram's response
    }
  }
  ["chatID2"]=> //ID2 => id chat two
  array(1) {
    ["message"]=>
    array(2) {
      [0]=>
      //Telegram's response 1
      [1]=>
      //Telegram's response 2
    }
  }
}
```
To get requests' links you can use `getRequest`:
```php
$linkList = $bot->getRequest();
```
**_Tokens_ will be omitted for security reasons**:
```php
array(2) {
  ["chatID1"]=> //ID1 => id chat one
  array(1) {
    ["message"]=>
    array(1) {
      [0]=>
      string(144) "https://api.telegram.org/botTOKEN/sendMessage?chat_id=ID1&text=test2&parse_mode=markdown&disable_web_page_preview=0&disable_notification=0"
    }
  }
  ["chatID2"]=> //ID2 => id chat two
  array(1) {
    ["message"]=>
    array(2) {
      [0]=>
      string(149) "https://api.telegram.org/botTOKEN/sendMessage?chat_id=ID2&text=test2&parse_mode=markdown&disable_web_page_preview=0&disable_notification=0"
      [1]=>
      string(149) "https://api.telegram.org/botTOKEN/sendMessage?chat_id=ID2&text=test1&parse_mode=markdown&disable_web_page_preview=0&disable_notification=0"
    }
  }
}
```
`getSuccess`, `getResult` and `getRequest` accept two arguments: chat's _name_ (or chat's _ID_) and function's _name_ (like _message_, _photo_ or _video_).
## Italiano
### Indice
1. [Introduzione ai bot di Telegram](#introduzione-ai-bot-di-telegram)
2. [Il mio primo bot](#il-mio-primo-bot)
3. [Requisiti](#requisiti)
4. [Importare la libreria](#importare-la-libreria)
5. [La logica di base per l'utilizzo](#la-logica-di-base)
6. [Inizializzare la libreria](#inizializzare-la-libreria)
7. [Metodi disponibili](#metodi-disponibili)
8. [Impostare una chat o un insieme di chat](#impostare-una-chat-o-un-insieme-di-chat)
    - [Inserire le prime chat](#inserire-le-prime-chat)
    - [Aggiungere una chat o un insieme di chat](#aggiungere-una-chat-o-un-insieme-di-chat)
    - [Rimuovere una chat o un insieme di chat](#rimuovere-una-chat-o-un-insieme-di-chat)
    - [Selezionare una chat o un insieme di chat](#selezionare-una-chat-o-un-insieme-di-chat)
9. [Usare un metodo](#usare-un-metodo)
10. [Reply Markup](#reply-markup)
    - [Impostare una keyboard](#impostare-una-keyboard)
    - [Metodo alternativo per i Reply Markup](#metodo-alternativo-per-i-reply-markup)
    - [Aggiungere un pulsante a una Keyboard](#aggiungere-un-pulsante-a-una-keyboard)
    - [Un esempio di Reply Keyboard](#un-esempio-con-una-reply-keyboard)
    - [Aggiungere una Keyboard a un metodo](#aggiungere-una-keyboard-a-un-metodo)
    - [Force Reply e Keyboard Remove](#force-reply-e-keyboard-remove)
11. [Eseguire tutti i metodi preparati](#eseguire-tutti-i-metodi-preparati)
12. [Ottenere le risposte di Telegram](#ottenere-le-risposte-di-telegram)
### Introduzione ai bot di Telegram
I bot di Telegram sono dei programmi creati da terzi che possono essere eseguiti nell'applicazione. Un bot, se scritto correttamente, più svolgere i più svariati compiti: chattare con un utente, inviare foto, video, documenti, audio, oppure aiutare nella gestione di gruppi e canali con le funzioni di kick, ban, restrizione, promozione, fissaggio di messaggi, modifica delle informazioni di base, elaborazione di statistiche. Per una descrizione completa delle potenzialità dei bot si rimanda alla [guida ufficiale](https://core.telegram.org/bots).
### Il mio primo bot
Coloro che non hanno mai creato un bot di Telegram rimarranno stupiti dalla semplicità con la quale questa operazione può essere compiuta. Infatti per generare il proprio bot personale occorre esclusivamente parlare con un bot, [Bot Father](https://t.me/BotFather), e seguire le istruzioni che vengono elencate. Tra le varie informazioni fornite da [Bot Father](https://t.me/BotFather), risulta di fondamentale importanza il _**token**_, un codice alfanumerico che permette di impostare il bot e istruirlo affinché esegua le operazioni scelte dal programmatore.

Dopo aver ottenuto il _token_ è possibile iniziare a usare questa libreria che semplifica ulteriorimente la scrittura del **codice PHP** necessario per il funzionamento del bot.
### Requisiti
Oltre al possesso del **token** di un bot, i requisiti per l'utilizzo della libreria in oggetto sono due:
* PHP >= 5.5
* `cURL` abilitato
### Importare la libreria
È possibile importare questa libreria tramite:
```
composer require ste25/php-telegram-bot-api dev-master@dev
```
### La logica di base
Questa libreria nasce con lo scopo di facilitare l'uso dei metodi messi a disposizione da Telegram per eseguire azioni tramite un bot.

La logica che verrà seguita è la seguente: **_Inizializzazione_ -> _Impostazione delle chat_ -> _Creazione dei contenuti da inviare_ -> _Esecuzione e invio_ -> _Controllo dei risultati (opzionale)_**.
### Inizializzare la libreria
È possibile creare un nuovo _bot_ con il comando:
```php
<?php
require_once 'vendor/autoload.php'; //or your path to composer's autoload.

use ste25\Telegram\Bot;

$bot = new Bot('TOKEN');
```
Naturalmente al posto di _TOKEN_ occorre specificare il _token_ del proprio bot.
### Metodi disponibili
I metodi forniti e descritti [dall'API Ufficiale di Telegram](https://core.telegram.org/bots/api#available-methods) attualmente disponibili sono:

|Metodo         |Funzione nella libreria |
|-----                |-------------    |
|getMe                |test             |
|sendMessage          |message          |
|forwardMessage       |forward          |
|sendPhoto            |photo            |
|sendAudio            |audio            |
|sendDocument         |document         |
|sendVideo            |video            |
|sendAnimation        |animation        |
|sendPoll             |poll             |
|sendChatAction       |cahtAction       |
|getUserProfilePhotos |propic           |
|getFile              |file             |
|kickChatMember       |kick             |
|unbanChatMember      |unban            |
|restrictChatMember   |restrict         |
|promoteChatMember    |promote          |
|exportChatInviteLink |inviteLink       |
|setChatTitle         |chatTitle        |
|setChatDescription   |chatDescription  |
|pinChatMessage       |pin              |
|unpinChatMessage     |unpin            |
|leaveChat            |leave            |
|getChat              |chatInfo         |
|getChatAdministrators|admins           |
|getChatMembersCount  |membersCount     |
|getChatMember        |member           |
|setChatStickerSet    |setSticker       |
|deleteChatStickerSet |deleteSticker    |
|answerCallbackQuery  |callbackQuery    |
### Impostare una chat o un insieme di chat
Quasi tutti i metodi di Telegram dedicati ai bot richiedono di specificare un **ID identificatore della chat** nella quale l'operazione descritta dal metodo sarà eseguita. La librearia cerca di semplificare questa operazione in modo da **evitare di specificare l'ID o gli ID** ogni volta che si richiama una funzione.
#### Inserire le prime chat
Il ruolo centrale nella gestione delle chat è svolto dalla **funzione `chat`**. Quest'ultima specifica e imposta una **chat o un gruppo di chat** con cui il bot opererà. La sintassi è la seguente:
```php
$bot->chat('first_id', 'second_id', 'third_id', 'etc...');
```
È possibile anche utilizzare un **array per _nominare_ le varie chat**, in modo da poter essere facilmente richiamate in seguito (rimando alla descrizione della funzione [`selectChat`](#selezionare-una-chat)).
```php
$bot->chat(['Sheldon' => 'first_id', 'Leonard' => 'second_id', 'Howard' => 'third_id', 'Etc...' => 'etc...]);
```
**Non è necessario usare la funzione `chat` prima di _ogni_ metodo**, è _sufficiente_ impostare le chat **una sola volta**!

Nel caso di una seconda chiamata della funzione `chat`, le chat precedentemente inserite saranno sovrascritte.
#### Aggiungere una chat o un insieme di chat
Dopo aver eseguito una prima volta la funzione `chat`, si può aggiungere una o più chat con la funzione `addChat`:
```php
$bot->addChat('fourth_chat', 'fifth_chat', 'sixth_chat', 'etc...');
```
Anche in questo caso è possibile usare un array per nominare le chat aggiunte:
```php
$bot->addChat(['Amy' => 'fourth_chat', 'Penny' => 'fifth_chat', 'Bernadette' => 'sixth_chat', 'Etc...' => 'etc...]);
```
#### Rimuovere una chat o un insieme di chat
Naturalmente è anche possibile rimuovere dall'elenco una o più chat tramite la funzione `removeChat`:
```php
$bot->removeChat('first_chat', 'fifth_chat', 'etc...');
```
**Se in precedenza sono stati specificati dei _nomi_ per le chat è possibile usare gli stessi**: la funzione infatti dapprima cerca l'esistenza del _nome_, se questo non esiste assume che si sta passando un _ID completo_, pertato sfrutta quest'ultimo.
```php
$bot->removeChat('Sheldon', 'Penny', 'etc...');
```
oppure tramite un array:
```php
$bot->removeChat(['Sheldon', 'Penny', 'etc...']);
```
#### Selezionare una chat o un insieme di chat
Di defatul tutti i comandi eseguiti vengono applicati a _ogni_ chat. Ciò significa che se ad esempio si prepara un messaggio con la funzione `message` e lo si invia, il suo contenuto sarà recapitato a _tutte le chat specificate_. In alcuni casi, però, si vuole compiere azioni differenti per chat differenti. Ciò risulta possibile grazie alla funzione `selectChat`, la cui sintassi è la seguente:
```php
$bot->selectChat('chat_id');
```
**Se in precedenza sono stati specificati dei _nomi_ per le chat è possibile usare gli stessi**: la funzione infatti dapprima cerca l'esistenza del _nome_, se questo non esiste assume che si sta passando un _ID completo_, pertato sfrutta quest'ultimo.
```php
$bot->selectChat('Leonard'); //Leonard's chat_id was added previously.
```
Per **effettuare una selezione _multipla_** si possono semplicemente passare le chat separate da virgole:
```php
$bot->selectChat('Sheldon', 'Leonard'); //Sheldon's and Leonard's chat_id were added previously.
```
oppure tramite array:
```php
$bot->selectChat(['Sheldon', 'Leonard']); //Sheldon's and Leonard's chat_id were added previously.
```
Per **selezionare nuovamente tutte le chat** si può richiamare la funzione senza alcun argomento:
```php
$bot->selectChat(); //Select all chat.
```
**_Attenzione!_** **Non** è possibile passare alla funzione `selectChat` una chat mai inserita con la funzione `chat`. Ossia: **tutte** le chat con cui comunicherà il bot **devono** essere specificate tramite la funzione `chat`.
### Usare un metodo
La libreria riprende i metodi fondamentali forniti da Telegram e li ottimizza per un uso più semplice e diretto. Ogni metodo ha i suoi parametri: esclusi l'ID della chat (di cui si è già detto) e il _reply_markup_ (di cui si dirà a breve) **tutti i parametri dei metodi seguono l'ordine e il nome specificati [dall'API Ufficiale di Telegram](https://core.telegram.org/bots/api#available-methods)**.

Vediamo nel dettaglio come usare la funzione `message`.

Si può **preparare un messaggio** con la seguente sintassi:
```php
$bot->message($text, $parse_mode = 'markdown', $disable_web_page_preview = false, $disable_notification = false, $reply_to_message_id = null); //Arguments' name and order follow the official API!
```
Gli **argomenti essenziali** sono quelli specificati dall'API di Telegram (nel caso del messaggio, l'unico argomento richiesto è il _testo_, nel caso della foto, la stringa che identifica il file da inviare e così via...).

È possibile **passare un array** per specificare solo gli argomenti rilevanti!
```php
$bot->message(['text' => 'First message!', 'disable_notification' => true]); //Prepare a message with content "First message!" and disable_notification set to true 
```
Tutti gli altri argomenti saranno lasciati alle impostazioni di default di Telegram.

È possibile **preparare più messaggi contemporaneamente** passando un array di messaggi:
```php
$bot->message([['First message!'], ['Second message'], ['Third message']]); //Prepare three messages
```
Naturalmente anche in questo caso si possono specificare solo gli argomenti rilevanti:
```php
$bot->message([['text' => 'First message!', 'disable_notification' => true], ['text' => '<b>Second message</b>', 'parse_mode' => 'html]]); //Prepare two messages
```
È possibile **preparare messaggi differenti per chat differenti**:
```php
$bot->selectChat('Howard', 'Bernadette')->message('To Howard and Bernadette!')->selectChat('Sheldon')->message('To Sheldon');
```
È possibile preparare messaggi diferenti per chat differenti e **messaggi comuni a tutti**:
```php
$bot->message('Message to all people!')->selectChat('Howard', 'Bernadette')->message('To Howard and Bernadette!')->selectChat('Sheldon')->message('To Sheldon');
```
È possibile **combinare più metodi**:
```php
$bot->message('Message to all people!')->selectChat('Penny')->photo('Photo to Penny')->selectChat()->video('Video to all!');
```
### Reply Markup
I _Reply Markup_ sono sempre la parte più difficile da gestire. La libreria cerca di semplificare anche questa operazione.
#### Impostare una keyboard
Per **impostare una keyboard** si può utilizzare la funzione `keyboard` che accetta come argomento il tipo (_keyboard_ oppure _inline_keyboard_, di default verrà creata una _inline_keyboard_):
```php
$keyboard = $bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']])->fromButtons([2, 1])->create();
```
L'esempio genererà una keyboard inline con tre pulsanti-link: due nella prima riga, uno nella seconda.

**Curiosità:** la variabile `$keyboard` generata con le funzioni precedenti conterrà:
```php
array(1) {
  ["inline_keyboard"]=>
  array(2) {
    [0]=>
    array(2) {
      [0]=>
      array(2) {
        ["text"]=>
        string(5) "text1"
        ["url"]=>
        string(19) "https://example1.it"
      }
      [1]=>
      array(2) {
        ["text"]=>
        string(5) "text2"
        ["url"]=>
        string(19) "https://example2.it"
      }
    }
    [1]=>
    array(1) {
      [0]=>
      array(2) {
        ["text"]=>
        string(5) "text3"
        ["url"]=>
        string(19) "https://example3.it"
      }
    }
  }
}
```

Vediamo nel dettaglio la descrizione delle varie funzioni.

Questo codice _comunica_ il tipo di keyboard che si intende creare:
```php
$bot->keyboard('inline_keyboard'); //or simply $bot->keyboard();
```
La funzione `inlineButtons` crea dei pulsanti inline, mentre la funzione `replyButtons` crea dei pulsanti reply. I parametri sono specificati da e seguono l'ordine dell'[API Ufficiale](https://core.telegram.org/bots/api#inlinekeyboardbutton).
```php
$bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']]);
```
Come per tutti i metodi della libreria si può passare un array avente chiavi uguali al nome degli argomenti da specificare:
```php
$bot->keyboard()->inlineButtons([['text' => 'text1', 'url' => 'https://example1.it'], ['text' => 'text2', 'callback_data' => 'my_data']]);
```
Per generare un **singolo** pulsante si può usare la scrittura semplificata:
```php
$bot->keyboard()->inlineButtons($text, $url = '', $callback_data = '', $switch_inline_query = '', $switch_inline_query_current_chat = '', $callback_game = null, $pay = false);
```
O un array:
```php
$bot->keyboard()->inlineButtons(['text' => 'content', 'pay' => true]);
```
La funzione `fromButtons` prepara la keyboard a partire dai pulsante specificati in precedenza. Essa accetta come argomento un array che indica quanti pulsanti andranno in quali righe: il primo elemento dell'array indica il numero di pulsanti della prima riga, il secondo il numero della seconda e così via...
```php
$keyboard = $bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']])->fromButtons([2, 1]);
```
La funzione `create` restituisce l'array completo che rappresenta la keyboard ed elimina tutti i parametri precedentemente inseriti, preparando la classe per una nuova keyboard. Essa **accetta degli argomenti solo nel caso di reply keyboard**: questi sono, nell'ordine _resize_keyboard_ (default false), _one_time_keyboard_ (default false), _selective_ (default false).
```php
$keyboard = $bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']])->fromButtons([2, 1])->create();
```
#### Metodo alternativo per i Reply Markup
Vi è un approccio alternativo per la creazione delle keyboard, riassunto nel seguente codice:
```php
$keyboard = $bot->keyboard()->inlineButtons('button 1', 'https://example1.com')->insert()->row()->inlineButtons([['button 2', 'https://example2.com'], ['button 3', 'https://example3.com']])->insert()->create();
```
Con questo approccio è possibile **generare riga per riga** la keyboard.
La funzione `insert` inserisce nella riga attuale i pulsanti precedentemente creati e li elimina dalla lista, la funzione `row` crea una nuova riga. **Alla fine occorre sempre chiamare la funzione `create`**.
#### Aggiungere un pulsante a una keyboard
**Questo metodo deve essere chiamato _prima di generare la keyboard con la funzione_ `create`!**

A volte risulta comodo impostare i parametri di una keyboard e modificarli in seguito. Aggiungere un pulsante a una keyboard è semplicissimo. Dapprima si **creano i pulsanti da inserire**, in seguito si **seleziona la riga** dove si vuole inserire il pulsante con la funzione `selectRow`:
```php
$bot->selectRow(1);
```
Infine si **indica la posizione**:
```php
$bot->selectRow(1)->addButtons('end');
```
La funzione `addButtons` accetta argomenti numerici oppure le keywords _start_ ed _end_ per inserire i pulsanti rispettivamente all'inizio o alla fine della riga selezionata.
#### Un esempio con una Reply Keyboard
```php
$keyboard = $bot->keyboard('keyboard')->replyButtons([['First'], ['Second'], ['Third']])->fromButtons([1, 2])->create($resize_keyboard = false, $one_time_keyboard = false, $selective = false);
```
**Curiosità:** la variabile `$keyboard` generata con le funzioni precedenti conterrà:
```php
array(4) {
  ["keyboard"]=>
  array(2) {
    [0]=>
    array(1) {
      [0]=>
      array(1) {
        ["text"]=>
        string(5) "First"
      }
    }
    [1]=>
    array(2) {
      [0]=>
      array(1) {
        ["text"]=>
        string(6) "Second"
      }
      [1]=>
      array(1) {
        ["text"]=>
        string(5) "Third"
      }
    }
  }
  ["resize_keyboard"]=>
  bool(false)
  ["one_time_keyboard"]=>
  bool(false)
  ["selective"]=>
  bool(false)
}
```
#### Aggiungere una keyboard a un metodo
Dopo aver creato la keyboard, la si può aggiungere a un metodo che la supporta (rimando alla [pagina API Ufficiale](https://core.telegram.org/bots/api#available-methods)) con la funzione `withKeyboard`:
```php
$keyboard = $bot->keyboard()->inlineButtons([['text1', 'https://example1.it'], ['text2', 'https://example2.it'], ['text3', 'https://example3.it']])->fromButtons([2, 1])->create();

$bot->message('Message with keyboard!')->withKeyboard($keyboard);
```
#### Force Reply e Keyboard Remove
Si può aggiungere a un metodo che li supporta un _Force Reply_ e un _Keyboard Remove_ tramite le funzioni `withForceReply` e `withKeyboardRemove`:
```php
$bot->message('Message with Force Reply!')->withForceReply($selective = false);
```
```php
$bot->message('Message with Keyboard Remove!')->withKeyboardRemove($selective = false);
```
### Eseguire tutti i metodi preparati
Quando si sono preparati tutti i metodi da eseguire, si **deve richiamare** la funzione `send`:
```php
$bot->message('Message to all people!')->selectChat('Penny')->photo('Photo to Penny')->selectChat()->video('Video to all!')->send();
```
### Ottenere le risposte di Telegram
Dopo aver eseguito la funzione `send` è possibile verificare lo status delle richieste con la funzione `getSuccess`:
```php
$successList = $bot->getSuccess();
```
La funzione restituisce un array contenente tutti i metodi eseguiti e le singole chat **precedute dalla keyword _chat_** come chiavi, mentre come elemento vi sono i valori booleani che indicano il successo (o l'insuccesso) dell'esecuzione:
```php
array(2) {
  ["chatID1"]=> //ID1 => id chat one
  array(1) {
    ["message"]=>
    array(1) {
      [0]=>
      bool(true)
    }
  }
  ["chatID2"]=> //ID2 => id chat two
  array(1) {
    ["message"]=>
    array(2) {
      [0]=>
      bool(true)
      [1]=>
      bool(true)
    }
  }
}
```
Per ottenere le informazioni restituite da Telegram si può usare la funzione `getResult`. Nel caso di insuccesso come elemento verrà inserito l'errore e la sua descrizione:
```php
$resultList = $bot->getResult();
```
Le informazioni sono restituite come array:
```php
array(2) {
  ["chatID1"]=> //ID1 => id chat one
  array(1) {
    ["message"]=>
    array(1) {
      [0]=>
      //Telegram's response
    }
  }
  ["chatID2"]=> //ID2 => id chat two
  array(1) {
    ["message"]=>
    array(2) {
      [0]=>
      //Telegram's response 1
      [1]=>
      //Telegram's response 2
    }
  }
}
```
Per ottenere un elenco dei link a cui si è fatta la richiesta tramite Curl si può usare la funzione `getRequest`:
```php
$linkList = $bot->getRequest();
```
**Per ragioni di sicurezza nei link viene oscurato il _token_ del bot**:
```php
array(2) {
  ["chatID1"]=> //ID1 => id chat one
  array(1) {
    ["message"]=>
    array(1) {
      [0]=>
      string(144) "https://api.telegram.org/botTOKEN/sendMessage?chat_id=ID1&text=test2&parse_mode=markdown&disable_web_page_preview=0&disable_notification=0"
    }
  }
  ["chatID2"]=> //ID2 => id chat two
  array(1) {
    ["message"]=>
    array(2) {
      [0]=>
      string(149) "https://api.telegram.org/botTOKEN/sendMessage?chat_id=ID2&text=test2&parse_mode=markdown&disable_web_page_preview=0&disable_notification=0"
      [1]=>
      string(149) "https://api.telegram.org/botTOKEN/sendMessage?chat_id=ID2&text=test1&parse_mode=markdown&disable_web_page_preview=0&disable_notification=0"
    }
  }
}
```
In questi ultimi tre metodi è possibile ottenere i dati di una singola chat passando come argomento il _nome_ o _l'ID_ della chat.

È inoltre possibile ottenere i dati di un singolo metodo passando sia il _nome_ o _l'ID_ della chat che il _nome_ della funzione a cui si è interessati.
