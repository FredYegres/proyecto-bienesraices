<?php 

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {
    public static function crear(Router $router) {
        $vendedor = new Vendedor;
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vendedor = new Vendedor($_POST['vendedor']);
    
            //Verificar que todos los campos sean validos
            $errores = $vendedor->validar();
    
            if(empty($errores)) {
                //Guardar en la DB
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores,
        ]);
    }

    public static function actualizar(Router $router) {
        $vendedores = Vendedor::all();
        $ids = verificarId($vendedores);
        $id = validarORedireccionar('/admin');
        $errores = Vendedor::getErrores();

        if(in_array($id, $ids)) {
            $vendedor = Vendedor::find($id);
        } else {
            header ("Location: /admin");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);

            //Verificar que todos los campos sean validos
            $errores = $vendedor->validar();

            if(empty($errores)) {
                //Guardar en la DB
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminar(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if ($id) {
                $tipo = $_POST['tipo'];
    
                if(validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}