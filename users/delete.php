<?php
require_once 'C:/OSPanel/domains/diplom/init.php';

//print_r($_GET);

$user_id = $_GET['id'];

database::getInstance()->delete('users', ['id', '=', $user_id]);

redirect::to('index.php');
