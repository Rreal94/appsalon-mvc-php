<?php
namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {
    public static function login(Router $router) {
        if(isset($_SESSION['login'])){
            header('Location: /admin');
        }
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    
                    $resultado = $usuario->comprobarPasswordYVerificado($auth->password);
                    if($resultado){
                        session_start();
                        $_SESSION['id'] = $usuario->id; 
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        if($usuario->admin){
                            $_SESSION["admin"] = $usuario->admin ?? null;

                            header('location: /admin');
                        }else{
                            header('location: /cita');
                        }
                    }
                }else{
                    Usuario::setAlerta('error', 'El usuario no esta registrado');
                }
            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas' => $alertas
        ]);
    }

    public static function logout(){
        session_destroy();
        header('Location: /');
    }

    public static function olvide(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email',s($auth->email));

                if(!$usuario || !$usuario->confirmado){
                    Usuario::setAlerta('error','El usuario no esta registrado o la cuenta no ha sido verificada');
                }else{
                    $usuario->crearToken();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->resetearPassword();
                    
                    $resultado = $usuario->guardar();
                    if($resultado){
                        Usuario::setAlerta('exito','Enviamos a tu correo las instrucciones para resetear tu password');
                    }
                }
            }
              
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router) {
        $alertas = [];
        $mostrar = false;

        $token = s($_GET['token']);
        $usuario = Usuario::where('token',$token);

        if(!$usuario){
            Usuario::setAlerta('error','Error al reasetear el password');
            $mostrar = false;
        }else {
            $mostrar = true;
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $usuario->password = s($_POST['password']);

                $alertas = $usuario->validarPassword();

                if(empty($alertas)){
                    $usuario->hashPassword();
                    $usuario->token = "";
                    $resultado = $usuario->guardar();
                    if($resultado){
                        Usuario::setAlerta('exito','El password se actualizo correctamente');
                        $email = new Email($usuario->email, $usuario->nombre);
                        $email->confirmarCambioPassword();
                        $mostrar = false;
                    }
                }
                
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/actualizar-password',[
            'alertas' => $alertas,
            'token' => $token,
            'mostrar' => $mostrar
        ]);
    }

    public static function crear(Router $router){
        $usuario = new Usuario();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)){

                $usuario->hashPassword();

                $usuario->crearToken();

                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                $email->enviarConfirmacion();

                $resultado = $usuario->guardar();
                if($resultado){
                    $alertas['exito'][] = 'Ingresa a tu correo para activar tu cuenta'; 
                }

            }

        }
        
        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]); 
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        if($token){
            $usuario = Usuario::where('token', $token);
        }
        if($usuario){
            $usuario->confirmado = 1;
            $usuario->token = "";
            $usuario->guardar();
            Usuario::setAlerta('exito','El usuario ha sido validado correctamente');
        }else{
            Usuario::setAlerta('error','No hay ningun usuario para validar con este token');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]); 
    }
}