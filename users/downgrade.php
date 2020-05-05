<?php

require_once 'C:/OSPanel/domains/diplom/init.php';

//print_r($_GET);

$id = $_GET['id'];

database::getInstance()->$users = Database::getInstance()->update('users', $id, [
    'group_id' => 1,
]);

redirect::to('index.php');
