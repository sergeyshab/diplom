<?php

class Token {
    public static function generate() {
        return Session::put(Config::get('session.token_name'), md5(uniqid())); // вместо Config::get('session.token_name') у нас сточка 'token' которая передается в переменную $name метода Session::put(),
                                                                               // а md5(uniqid() наш сгенерированный токен, строчка '8b2c3fc0cc2ae378ad3d4e1a920a0d21', которая передается в переменную $value метода Session::put()
    }

    public static function check($token) { // в переменную $token передаётся строчка '8b2c3fc0cc2ae378ad3d4e1a920a0d21'
        $tokenName = Config::get('session.token_name'); // здесь получается следующее $tokenName = 'token'

        if(Session::exists($tokenName) && $token == Session::get($tokenName)) { // если в сессии существует значение с кючем 'токен'
                                                                                // и значение в форме ($token = '8b2c3fc0cc2ae378ad3d4e1a920a0d21') и значение в сессии под именем ($tokenName = 'token') совпадают и возвращает true,
                                                                                // тогда нам нужно удалить эту сессию, получается токен у нас разовый
            Session::delete($tokenName);
            return true;
        }

        return false;
    }
}