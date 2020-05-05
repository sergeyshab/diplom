<?php

class Input {

    public static function exists($type = 'post') {
        //echo $type;
        switch ($type) {
            case 'post': return (!empty($_POST)) ? true : false;
            case 'get': return (!empty($_GET)) ? true : false;
            default: return false;
            break;

        }
    }

// здесь мы ловим строчку значения нэйма и проверяем есть ли такая строчка, такое значение, ключ в нашем глобальном масиве $_POST либо $_GET,
// если есть - возвращаем его, иначе возвращаем пустое значение
    public static function get($item) {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } else if(isset($_GET[$item])) {
            return $_GET[$item];
        }

        return '';
    }

}