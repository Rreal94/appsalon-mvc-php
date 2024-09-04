<?php


namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Serivicio;

class APIController {

    public static function index() {
        $servicios = Serivicio::all();
        echo json_encode($servicios);
    }


    public static function guardar(){
        $cita  = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];
        
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio){
            $args = [
                'citaid' => $id,
                'servicioid' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
        $id = $_POST['id'];
        $fecha = $_POST['fecha'];
        $cita = cita::find($id);
        $cita->eliminar();
        header('Location: /admin?eliminado=true&fecha='. $fecha);
    }
}