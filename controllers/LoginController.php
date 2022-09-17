<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController {
    public static function login(Router $router) {
        $auth = new Admin;
        $errores = Admin::getErrores();
        $usuarioInvalido = false;
        $passwordInvalida = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);
            $errores = $auth->validar();
    
            if (empty($errores)) {
                //Verificar si usuario existe
                $resultado = $auth->existeUsuario();

                if(!$resultado->num_rows) {
                    $usuarioInvalido = true;
                } else {
                    //Verificar Password
                    $autenticado = $auth->comprobarPassword($resultado);

                    if($autenticado) {
                        //Autenticar usuario
                        $auth->autenticar();
                        
                    } else {
                        $passwordInvalida = true;
                    }
                }
            }
        }

        $router->render('auth/login', [
            'errores' => $errores,
            'auth' => $auth,
            'usuarioInvalido' => $usuarioInvalido,
            'passwordInvalida' => $passwordInvalida,
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];

        header('Location: /');
    }
}