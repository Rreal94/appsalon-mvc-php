<?php

namespace Model;

class Usuario extends ActiveRecord{

    protected static $tabla = "usuarios";
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    public function validarNuevaCuenta() {
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if(!$this->telefono){
            self::$alertas['error'][] = 'El telefono es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El e-mail es obligatorio';
        }
        if(self::validarUsuario()){
            self::$alertas = [];
            self::$alertas['error'][] = 'El usuario ya exite. <a href="/olvide">Olvidaste tu password?</a>';
            return self::$alertas;
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if(strlen($this->password) < 8){
            self::$alertas['error'][] = 'El password debe tener mas de 8 caracteres';
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if(strlen($this->password) < 8){
            self::$alertas['error'][] = 'El password debe tener mas de 8 caracteres';
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'Ingresa un email valido';
        }

        return self::$alertas;
    }

    public function validarLogin() {
        if(!$this->email){
            self::$alertas['error'][] = 'El e-mail no se ha ingresado';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'Ingresa tu password para poder acceder';
        }

        return self::$alertas;
    }

    public function validarUsuario() {
        $query = "SELECT * FROM " . static::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = static::consultarSQL($query);
        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordYVerificado($password){
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado){
            self::$alertas["error"][] = "El password es incorrecto o la cuenta no esta verificada"; 
        }
        return $resultado;
    }

}