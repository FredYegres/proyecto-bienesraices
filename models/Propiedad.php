<?php

namespace Model;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedor_id'];

    //Errores
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $vendedor_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedor_id = $args['vendedor_id'] ?? '';
    }

    public function validar() {
        
        if(!$this->titulo) {
            self::$errores['titulo'] = "Debes añadir un titulo";
        }

        if(!$this->precio) {
            self::$errores['precio'] = 'El Precio es Obligatorio';
        }

        if(!$this->descripcion) {
            self::$errores['descripcion'] = 'La descripción es obligatoria';
        } else if(strlen( $this->descripcion) < 50 ) {
            self::$errores['descripcion'] = 'La descripción debe tener al menos 50 caracteres';
        }

        if(!$this->habitaciones) {
            self::$errores['habitaciones'] = 'El Número de habitaciones es obligatorio';
        }
        
        if(!$this->wc) {
            self::$errores['wc'] = 'El Número de Baños es obligatorio';
        }

        if(!$this->estacionamiento) {
            self::$errores['estacionamiento'] = 'El Número de lugares de Estacionamiento es obligatorio';
        }
        
        if(!$this->vendedor_id) {
            self::$errores['vendedor_id'] = 'Elige un vendedor';
        }

        if(!$this->imagen ) {
            self::$errores['imagen'] = 'La Imagen es Obligatoria';
        }
        return self::$errores;
    }

    public function mostrarErrores($nombre, $descripcion = false) {
        if(!empty(static::$errores)) {
            if ($descripcion && (strlen( $this->descripcion ) < 50)) {
                echo '<div class="alerta error">';
                echo static::$errores[$nombre];
                echo '</div>';
            }
            if(!$this->$nombre && !$descripcion) {
                echo '<div class="alerta error">';
                echo static::$errores[$nombre];
                echo '</div>';
            }
        }
        
    }
}