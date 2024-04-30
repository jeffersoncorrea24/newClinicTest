<?php

    class codigos{
        private $secret;
        private $id_usuario;
        private $fecha;
        private $token;
        private $correo;
        
        
        //GOOGLE AUTHENTICATOR
        public function getCodigo(){
            return $this->secret;
        } 

        public function setCodigo($secret){
            $this->secret = $secret;
        }

        public function getId_Usuario(){
            return $this->id_usuario;
        } 

        public function setId_Usuario($id_usuario){
            $this->id_usuario = $id_usuario;
        }

        public function getFecha(){
            return $this->fecha;
        } 

        public function setFecha($fecha){
            $this->fecha = $fecha;
        }
        // TOKEN
        public function getToken(){
            return $this->token;
        } 

        public function setToken($token){
            $this->token = $token;
        }

        public function getCorreo(){
            return $this->correo;
        } 

        public function setCorreo($correo){
            $this->correo = $correo;
        }


}
?>