<?php

/**
 * (c) 2016 http://opersms.uz
 *
 * Ниже даны определения переменным, используемым в исходном коде.
 * LOGIN      - логин, выданный технической службой
 * PASSWORD   - пароль, выданный вместе с логином
 * NUMBER     - номер телефона получателя в международном формате без плюса (+)
 * TEXT       - текст SMS сообщения в кодировке UTF-8
 * REQUEST_ID - ID запроса
 */

namespace App\Helpers\Common;

use App\Helpers\Log\TelegramLog;

class Sms
{
    const LOGIN = 'book_media';
    const PASSWORD = "9VXBBCB3TOkC";
    
    public static function send($phone, $text)
    {
        // check phone format
        if (!preg_match("/^[0-9]{12}$/", $phone)) {
            return [
                "success" => false,
                "message" => "Phone number format is incorrect"
            ];
        }

        // Заполняем массив данных любым удобным способом:
        $data = array(
            // Используйте только один вариант отправки сообщений:
            // Отправка сообщения обычным образом:
            array('phone' => $phone, 'text' => utf8_encode($text)),
            // Если сообщения приходят в неправильной кодировке, используйте iconv:
            // array('phone' => $phone, 'text' => utf8_encode(iconv('windows-1251', 'utf-8', $text))),
        );

        /**
         * В виду ограничений на максимальное количество получателей в одном пакете,
         * делим массив данных на небольшие пакеты по 50 элементов и формируем POST
         * HTTP запрос с помощью модуля cURL:
         */
    
        $array = array_chunk($data, 50, true);

        foreach ($array as $chunk) {

            // Инициализация соединения с сервером OperSMS:
            $ch = curl_init("http://83.69.139.182:8080/");
            // Включаем опцию возврата ответа:
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // Устанавливаем ограничение на выполнение запроса 30 секунд:
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            // Если необходимо соединяться по SSL, раскомментируйте следующие строки:
            //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
            // Собственно, сами данные:
            // * ВНИМАНИЕ!!! Следует использовать только один вариант конструкции, 
            // * формирующей строку данных!
        
            // Вариант 1. Рекомендуется следующая конструкция:
            // curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            //     "login"    => self::LOGIN,
            //     "password" => self::PASSWORD,
            //     // Кодируем массив в формат JSON:
            //     "data"     => json_encode($chunk)
            // ));
        
            // Вариант 2. Если предыдущий вариант не работает,
            // используйте следующую конструкцию:
            curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".self::LOGIN."&password=".self::PASSWORD."&data=" . json_encode($chunk));

            // Записываем результат выполнения запроса в переменную:
            $result = curl_exec($ch);
            // Закрываем соединение с сервером OperSMS:
            curl_close($ch);

            /**
             * Далее приведен пример получения статуса отправленного сообщения.
             * Возвращается строка в формате JSON, которая записывается в переменную
             * для дальнейшей обработки программным обеспечением клиента:
             */
        
            // Преобразуем предыдущий ответ сервера из формата JSON в обычный массив:
            $array = json_decode($result, true);

            // send log for check 
            // TelegramLog::log($array);

            // ~~~~~~~~~~~~~~~~~~~~~~ CHECk SMS STATUS ~~~~~~~~~~~~~~~~~~~~~~
        
            // Извлекаем из полученного массива request_id:
            // $request_id = $array[0]['request_id'];

            // Инициализация соединения с сервером OperSMS:
            // $ch = curl_init("http://83.69.139.182:8081/status");
            // Включаем опцию возврата ответа:
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // Устанавливаем ограничение на выполнение запроса 30 секунд:
            // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            // Если необходимо соединяться по SSL, раскомментируйте следующие строки:
            //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
            // Собственно, сами данные:
            // * ВНИМАНИЕ!!! Следует использовать только один вариант конструкции, 
            // * формирующей строку данных!
        
            // Вариант 1. Рекомендуется следующая конструкция:
            // curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            //     "login"    => self::LOGIN,
            //     "password" => self::PASSWORD,
            //     // Кодируем массив в формат JSON:
            //     "data"     => '[{"request_id":"' . $request_id . '"}]'
            // ));
        
            // Вариант 2. Если предыдущий вариант не работает,
            // используйте следующую конструкцию:
            // curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".self::LOGIN."&password=".self::PASSWORD."&data=[{\"request_id\":\"" . $request_id . "\"}]");

            // Записываем результат выполнения запроса в переменную:
            // $status = curl_exec($ch);
            // Закрываем соединение с сервером OperSMS:
            // curl_close($ch);

            // send log for check 
            // TelegramLog::log(json_decode($status, true));
        
            // Извлекаем интересующие нас данные из результата запроса - статус доставки:
            // $state = $array[0]['delivery-notification']['status'][0]['$']['state'];
        
            /**
             * Кроме "state" (string) массив также содержит другую полезную информацию:
             * "code" (integer),
             * "delivered-date" (date Y-m-d H:i:s),
             * "description" (string),
             * "message-count" (integer),
             * "ordinal" (integer)
             */
        }

    }
}
