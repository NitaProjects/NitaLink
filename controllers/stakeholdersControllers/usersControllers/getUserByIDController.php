<?php

declare(strict_types=1);

include_once '../model/checks/Checker.php';
include_once '../persistence/MysqlUserAdapter.php';

$persistence = new MysqlUserAdapter();
$message = "Unsucessfully Request: ";
$id = (int)filter_input(INPUT_POST, 'id');

if ($id) {
    try {
        $u = $persistence->getUser($id);
        $message =  $u->getName().";".$u->getLevel().";".$u->getPoints();
    } catch (ServiceException $ex) {
        $message .= $ex->getMessage();
    }
} else {
    $message .= "No data found";
}

setcookie('response', $message, 0, '/', 'localhost');
header('location: ../views/UserActionResponse.php');
