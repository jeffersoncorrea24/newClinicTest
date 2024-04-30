<?php

    class Llama_roles{
        
        private $db;
        private $rol;
        
        public function __construct(){

            require_once("../model/vinculo.php");
          
            $this->db=Conectar::acceso();
            $this->rol=array();           
            
        }
        
        public function get_roles(){
            
            $consulta_roles=$this->db->prepare("SELECT id_roles, descripcion FROM hinfraestructura.roles WHERE id_roles !=:role AND id_roles !=:roleFuncionario ORDER BY descripcion");
            $consulta_roles->bindValue('role',7);
            $consulta_roles->bindValue('roleFuncionario',4);
            $consulta_roles->execute();
            
            while($filas_roles=$consulta_roles->fetch(PDO::FETCH_ASSOC)){
                
                $this->rol[]=$filas_roles;
            }
                return $this->rol;
        }
        
        
    }



?>
