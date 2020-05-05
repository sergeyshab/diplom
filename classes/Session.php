<?php

class Session {
    public static function put($name, $value) { // в переменную $name передается сточка 'token', а в $value передается наше сгенерированное значение, например '8b2c3fc0cc2ae378ad3d4e1a920a0d21'
                                                // далее  записываем это значение в глобальный массив $_SESSION под именем 'token'
        return $_SESSION[$name] = $value;       // $_SESSION['token'] = '8b2c3fc0cc2ae378ad3d4e1a920a0d21';
    }

    public static function exists($name) { // в переменную $name передается строчка 'token'
        return (isset($_SESSION[$name])) ? true : false; // проверяем существует ли в сессии значении с ключем 'token', если да - возвращаем true, иначе false
    }

    public static function delete($name) { // в переменную $name передается строчка 'token', если сессия существует, то удаляем её
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function get($name) { // в переменную $name передается строчка 'token' и возвращается значение  $_SESSION['token'], которое должно быть равно '8b2c3fc0cc2ae378ad3d4e1a920a0d21'
        return $_SESSION[$name];
    }

    public static function flash($name, $string = '') { // в переменную $name передается ключ, например 'success', а в $string передаётся сообщение, например 'register success',
                                                        // либо пустая строка, если мы не записываем, а выводим flash сообщение, например  echo Session::flash('success');

        if(self::exists($name) && self::get($name) !== '') { // проверяем существует ли у нас такой ключ в нашей сессии, если сужествует и значение в нем не пустое,
            $session = self::get($name);                     // в таком случае выносим данное значение в переменную $session,
            self::delete($name);                             // удаляем текущий ключ тот, что мы передали (удаляем из сессии сообщение)
            return $session;                                 // и потом возвращаем эту переменную, которая хранит в себе сообщение из нашей сессии наружу и всё
        } else {
            self::put($name, $string); // записываем в сессию сообщение которое передаётся в переменную $string, под ключём, который передаётся в переменную $name,
                                       // например $name = 'succsess', $string = 'register success'
        }
    }
}
