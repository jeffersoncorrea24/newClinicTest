<?php

    class Usuario{
        
        
            private $id_usuario;
            private $nombre;
            private $tipoValidacion;
            private $correo;
            private $clave;
            private $id_roles;         
            private $uestado;
            private $ufecha_sistema;           
            private $usuario_inactiva;
            private $ufecha_inactivacion;
            private $usuario_activa;
            private $ufecha_activa;
            private $descripcion;


            /**********Tabla de Intentos*************/

            private $id_intentos;
            private $exitos;
            private $fallidos;
            private $intentos_total;
            private $ip;
            private $ticket;


            /***********Tabla de historial**************/
            private $codigo;
            private $ID_usuarios;
            private $fecha_registro;
            private $funcion_realizada;
         

                        
           
        function __construct(){}
        
        
        
        public function getIDusuario(){
            return $this->id_usuario;
        }

        public function setIDusuario($id_usuario){
            $this->id_usuario = $id_usuario;
        }
        
        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
        }
        
        public function getCorreo(){
            return $this->correo;
        }

        public function setCorreo($correo){
            $this->correo = $correo;
        }
        
        public function getClave(){
            return $this->clave;
        }

        public function setClave($clave){
            $this->clave = $clave;
        }
         public function getRoles(){
            return $this->id_roles;
        }

        public function setRoles($id_roles){
            $this->id_roles = $id_roles;
        }

        public function getUestado(){
            return $this->uestado;
        }

        public function setUestado($uestado){
            $this->uestado = $uestado;
        }

        public function getUfecha_sistema(){
            return $this->ufecha_sistema;
        }

        public function setUfecha_sistema($ufecha_sistema){
            $this->ufecha_sistema = $ufecha_sistema;
        }


        public function getUsuario_inactiva(){
            return $this->usuario_inactiva;
        }

        public function setUsuario_inactiva($usuario_inactiva){
            $this->usuario_inactiva = $usuario_inactiva;
        }

        public function getUfecha_inactivacion()
        {
            return $this->ufecha_inactivacion;
        }
        
        public function setUfecha_inactivacion($ufecha_inactivacion)
        {
            $this->ufecha_inactivacion = $ufecha_inactivacion;
            return $this;
        }

        public function getUfecha_activa(){
            return $this->ufecha_activa;
        }

        public function setUfecha_activa($ufecha_activa){
            $this->ufecha_activa = $ufecha_activa;
        }

        public function getUsuario_activa(){
            return $this->usuario_activa;
        }

        public function setUsuario_activa($usuario_activa){
            $this->usuario_activa= $usuario_activa;
        }

        public function getDescripcion()
        {
            return $this->descripcion;
        }
        
        public function setDescripcion($descripcion)
        {
            $this->descripcion = $descripcion;
            return $this;
        }
        
        public function getTipoValidacion()
        {
            return $this->tipoValidacion;
        }
        
        public function setTipoValidacion($tipoValidacion)
        {
            $this->tipoValidacion = $tipoValidacion;
            return $this;
        }
        
        /**************************************************************************/        
        /***************************INTENTOS***************************************/    
        /**************************************************************************/

        public function getId_intentos()
        {
            return $this->id_intentos;
        }
        
        public function setId_intentos($id_intentos)
        {
            $this->id_intentos = $id_intentos;
            return $this;
        }

        /**************************************************************************/

        public function getExitos()
        {
            return $this->exitos;
        }
        
        public function setExitos($exitos)
        {
            $this->exitos = $exitos;
            return $this;
        }

        /**************************************************************************/

        public function getTicket()
        {
            return $this->ticket;
        }
        
        public function setTicket($ticket)
        {
            $this->ticket = $ticket;
            return $this;
        }

        /**************************************************************************/

        public function getFallidos()
        {
            return $this->fallidos;
        }
        
        public function setFallidos($fallidos)
        {
            $this->fallidos = $fallidos;
            return $this;
        }

        /**************************************************************************/

        public function getIntentos_total()
        {
            return $this->intentos_total;
        }
        
        public function setIntentos_total($intentos_total)
        {
            $this->intentos_total = $intentos_total;
            return $this;
        }

        /**************************************************************************/

        public function getIp()
        {
            return $this->ip;
        }
        
        public function setIp($ip)
        {
            $this->ip = $ip;
            return $this;
        }

         /***************************************************************************************/        
        /***************************historial de funciones***************************************/    
        /***************************************************************************************/
          public function getIDusuarios(){
            return $this->ID_usuarios;
        }

        public function setIDusuarios($ID_usuarios){
            $this->ID_usuarios = $ID_usuarios;
        }
        
        public function getFecharegistro(){
            return $this->fecha_registro;
        }

        public function setFecharegistro($fecha_registro){
            $this->fecha_registro = $fecha_registro;
        }
        
        public function getFuncionrealizada(){
            return $this->funcion_realizada;
        }

        public function setFuncionrealizada($funcion_realizada){
            $this->funcion_realizada = $funcion_realizada;
        }
        
       
        
    }

?>
