<?php

namespace Model;

class Admin extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar() {
        
        if (!$this->email) {
            self::$errores['email'] = 'El email es obligatorio';
        }

        if (!$this->password) {
            self::$errores['password'] = 'La contraseña es obligatoria';
        }

        return self::$errores;
    }

    public function mostrarErrores($nombre) {
        if(!empty(static::$errores)) {
            if (!$this->$nombre) {
                echo '<div class="alerta error">';
                echo static::$errores[$nombre];
                echo '</div>';
            }   
        }
    }

    public function existeUsuario() {
        //Revisar si usuario exite
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);
        
        return $resultado;
    }

    public function comprobarPassword($resultado) {
        $usuario = $resultado->fetch_object();
        $autenticado = password_verify($this->password, $usuario->password);

        return $autenticado;
    }

    public function autenticar() {
        session_start();

        //Llenar arreglo de sesion
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}