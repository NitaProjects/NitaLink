<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlUserAdapter.php');

$persistence = new MysqlUserAdapter();

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
if ($username !== null && $username !== false && $password !== null && $password !== false) { 
    try {
        $user = $persistence->authentication($username, $password);
        setcookie('userid', $user->getId(), 0, '/', 'localhost');
        setcookie('username', $user->getName(), 0, '/', 'localhost');
        setcookie('usertype', $user->getType(), 0, '/', 'localhost');

        // Redirigir al dashboard apropiado basado en el tipo de usuario
        switch ($user->getType()) {
            case 'client':
                header('Location: ../views/stakeholders/clients/dashboardClient.php');
                break;
            case 'employee':
                header('Location: ../views/stakeholders/employees/dashboardEmployee.php');
                break;
            case 'provider':
                header('Location: ../views/stakeholders/providers/dashboardProvider.php');
                break;
            default:
                throw new Exception("Tipo de usuario no reconocido");
        }
        exit();
    } catch (Exception $ex) {
        header('Location: ../views/stakeholders/BadLogin.php');
        exit();
    }
}


