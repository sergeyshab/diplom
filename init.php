<?php
session_start();
//print_r($_SESSION);

require_once 'classes/Database.php';
require_once 'classes/Config.php';
require_once 'classes/Cookie.php';
require_once 'classes/Input.php';
require_once 'classes/Session.php';
require_once 'classes/Token.php';
require_once 'classes/Validate.php';
require_once 'classes/User.php';
require_once 'classes/Redirect.php';


/////////////////////////////////////////////////   CONFIG   ///////////////////////////////////////////////////////////

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'diplom',
        'something' => [
            'no' => [
                'foo' => [
                    'bar' => 'baz'
                ]
            ],

        ]
    ],

    'session' => [
        'token_name' => 'token',
        'user_session' => 'user'
    ],

    'cookie' => [
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ]

];

if(Cookie::exists(Config::get('cookie.cookie_name')) && !Session::exists(Config::get('session.user_session'))) {
    $hash = Cookie::get(Config::get('cookie.cookie_name'));
    $hashCheck = Database::getInstance()->get('user_session', ['hash', '=', $hash]);

    if($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();

    }
}