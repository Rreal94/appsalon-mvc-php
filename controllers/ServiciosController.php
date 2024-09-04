<?php

namespace Controllers;

use Model\Serivicio;
use MVC\Router;

class ServiciosController{
    public static function index(Router $router){
        session_start();
        isAuth();
        isAdmin();
        $nombre = $_SESSION['nombre'];

        $servicios = Serivicio::all();

        $router->render('/servicios/index',[
            'nombre' => $nombre,
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router){
        session_start();
        isAuth();
        isAdmin();
        $nombre = $_SESSION['nombre'];
        $alertas = [];
        $servicio = new Serivicio;
        $exito = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validarServicio();
            
            if(empty($alertas)){
                $resultado = $servicio->crear();
                if($resultado['resultado']){
                    $exito = true;
                    $servicio = new Serivicio;
                }
                if(!$resultado['resultado']){
                    $exito = false;
                }
            }
        }

        $router->render('/servicios/crear',[
            'nombre' => $nombre,
            'alertas' => $alertas,
            'servicio' => $servicio,
            'exito' => $exito
        ]);
    }

    public static function actualizar(Router $router){
        session_start();
        isAuth();
        isAdmin();
        $nombre = $_SESSION['nombre'];
        $alertas = [];
        $exito = null;
        if(!is_numeric($_GET['id'])){
            header('Location: /servicios');
        }
        $id = $_GET['id'];

        $servicio = Serivicio::find($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validarServicio();
            
            if(empty($alertas)){
                $resultado = $servicio->actualizar();
                if($resultado){
                    $exito = true;
                    $servicio = new Serivicio;
                }
                if(!$resultado){
                    $exito = false;
                }
            }
        }

        $router->render('/servicios/actualizar',[
            'nombre' => $nombre,
            'servicio' => $servicio,
            'alertas' => $alertas,
            'exito' => $exito
        ]);
    }

    public static function eliminar(Router $router){
        session_start();
        isAuth();
        isAdmin();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $servicio = Serivicio::find($_POST['id']);

            if($servicio){
                $servicio->eliminar();
                header('Location: /servicios?eliminado=1');
            }
            
        }
    }
}