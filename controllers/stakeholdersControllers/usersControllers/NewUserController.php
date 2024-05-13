<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/BuildException.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlUserAdapter.php');

$persistence = new MysqlUserAdapter();
$message = "Unsucessfully Request: ";
$usuari = filter_input(INPUT_POST, 'name');
$pswd = filter_input(INPUT_POST, 'pswd');
$type = filter_input(INPUT_POST, 'type');


if ($usuari and $pswd) {
        try {
            if ($persistence->exists($usuari) === false) {
                $id = $persistence->maxUserid() + 1;
                $user = new User($id, $usuari, $pswd, $type);
                $persistence->addUser($user);
                $message = "Changes done";
            } else {
                $message .= "User Exists";
            }
        } catch (ServiceException $ex) {
            $message .= $ex->getMessage();
        } catch ( BuildException  $ex) {
            $message .= $ex->getMessage();
        }  
    } else {
    $message .= "Few fields data found";
    }

setcookie('response', $message, 0, '/', 'localhost');
header('location: ../../../index.html');
