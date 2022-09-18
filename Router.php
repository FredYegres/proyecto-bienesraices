<?php

namespace MVC;

class Router {
    public $rutasGet = [];
    public $rutasPost = [];

    public function get($url, $fn) {
        $this->rutasGet[$url] = $fn;
    }
    public function post($url, $fn) {
        $this->rutasPost[$url] = $fn;
    }

    public function comprobarRutas() {
        session_start();

        $auth = $_SESSION['login'] ?? null;
        //Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        $urlActual = strtok($_SERVER["REQUEST_URI"], '?') ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            $fn = $this->rutasGet[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPost[$urlActual] ?? null;
        }

        //Protefer rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        }

        if($fn) {
            call_user_func($fn, $this);
        } else {
            $contenido = '
                <div class="error-404">
                    <h1>404</h1>
                    <h2>Not Found</h2>
                    <p>The resource requested could not be found on this server!</p>
                </div>
            ';
            include __DIR__ . "/views/layout.php";
        }
    }

    public function render($view, $datos = []) {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }
}