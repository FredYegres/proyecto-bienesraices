<?php

namespace Model;

class Vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {
        
        if(!$this->nombre) {
            self::$errores['nombre'] = "Debes añadir un nombre";
        }
        if(!$this->apellido) {
            self::$errores['apellido'] = "Debes añadir un apellido";
        }
        if(!$this->telefono) {
            self::$errores['telefono'] = "Debes añadir un teléfono";
        } else if(!preg_match('/[0-9]{11}/', $this->telefono)) {
            self::$errores['telefono'] = "Formato no válido";
        }

        return self::$errores;
    }
    
    public function mostrarErrores($nombre, $telefono = false) {
        if(!empty(static::$errores)) {
            if ($telefono && (!preg_match('/[0-9]{11}/', $this->telefono))) {
                echo '<div class="alerta error">';
                echo static::$errores[$nombre];
                echo '</div>';
            }
            if(!$this->$nombre && !$telefono) {
                echo '<div class="alerta error">';
                echo static::$errores[$nombre];
                echo '</div>';
            }
        }
        
    }
}