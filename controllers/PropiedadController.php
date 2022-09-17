<?php 

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    public static function index(Router $router) {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['result'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router) {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $propiedad = new Propiedad($_POST['propiedad']);

            //Generar nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Rezise imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
        
            //Verificar que todos los campos sean validos
            $errores = $propiedad->validar();

            if(empty($errores)) {
                //Crear carpeta
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                //Guardar imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                
                //Guardar en la DB
                $propiedad->guardar();

            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $propiedades = Propiedad::all();
        $ids = verificarId($propiedades);
        $id = validarORedireccionar('/admin');
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if(in_array($id, $ids)) {
            $propiedad = Propiedad::find($id);
        } else {
            header ("Location: /admin");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Asignar atributos
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);
    
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
    
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            $errores = $propiedad->validar();
    
            //Verificar que todos los campos sean validos
            if(empty($errores)) {
                /** SUBIDA DE ARCHIVOS **/
                if ($_FILES['propiedad']['tmp_name']['imagen']){
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
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
                    $propiedad = propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}