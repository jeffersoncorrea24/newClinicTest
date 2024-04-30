<?php 


class Funcionario{
	
	private $f_identificacion;
	private $f_nombre;
	private $f_email;
    private $f_email2;
	private $f_area;
	private $f_cargo;
	private $f_extension;
	private $f_rol;
    private $f_nombre_rol;
	private $f_usuario;
	private $f_contrasena;
    private $f_validacion;
    private $f_estado;
    private $f_fecha_sistema;
    private $f_usuario_inactivacion;
    private $f_fecha_inactivacion;
    private $f_fecha_activacion;
    private $f_usuario_activacion;
    /*Datos Acceso*/
    private $id_acceso;
    private $tipo_acceso;
    private $usuario;
    private $clave;  
    private $fecha_registro;
    private $estadosA;
    private $fecha_inactivacion;
    private $tipoValidacion;
    private $ticket;
    private $fecha;
    private $secret;
        /*Datos Tipos de Acceso*/
    private $descripcion;
        /* descripcion que se da al activar o inactivar un funcionario */
    private $descripcionFinal;
    private $centroCostos;
    private $departamento_interno;




	public function getF_identificacion(){
        return $this->f_identificacion;
    }
    public function setF_identificacion($f_identificacion){
        $this->f_identificacion = $f_identificacion;
    	} 

    public function getF_codigo(){
        return $this->secret;
    } 

    public function setF_codigo($secret){
        $this->secret = $secret;
    }

    public function getF_fecha(){
        return $this->fecha;
    } 

    public function setF_fecha($fecha){
        $this->fecha = $fecha;
    }

   	public function getF_nombre(){
   		return $this->f_nombre;
   	}
   	public function setF_nombre($f_nombre){
   		$this->f_nombre = $f_nombre;
   		}


   	public function getF_email(){
   		return $this->f_email;
   	}
   	public function setF_email($f_email){
   		$this->f_email = $f_email;
   	}

    public function getF_email2(){return $this->f_email2;}
    public function setF_email2($f_email2){$this->f_email2 = $f_email2;}


   	public function getF_area(){
   		return $this->f_area;
   	}
   	public function setF_area($f_area){
   		$this->f_area = $f_area;
   		}


   	public function getF_cargo(){
   		return $this->f_cargo;
   	}
   	public function setF_cargo($f_cargo){
   		$this->f_cargo = $f_cargo;
   		}


   	public function getF_extension(){
   	    return $this->f_extension;
   	}
   	public function setF_extension($f_extension){
   	    $this->f_extension = $f_extension;
   		}


   	public function getF_rol(){
   	    return $this->f_rol;
   	}   	
   	public function setF_rol($f_rol){
   	    $this->f_rol = $f_rol;
   		}
    
    public function getF_nombre_rol(){
   	    return $this->f_nombre_rol;
   	}   	
   	public function setF_nombre_rol($f_nombre_rol){
   	    $this->f_nombre_rol = $f_nombre_rol;
   		}


   	public function getF_usuario(){
   	    return $this->f_usuario;
   	}
   	public function setF_usuario($f_usuario){
   	    $this->f_usuario = $f_usuario;
   		}


   	public function getF_contrasena(){
   	    return $this->f_contrasena;
   	}
   	public function setF_contrasena($f_contrasena){
   	    $this->f_contrasena = $f_contrasena;
   	    }


   	public function getF_validacion(){
   	    return $this->f_validacion;
   	}
   	public function setF_validacion($f_validacion){
   	    $this->f_validacion = $f_validacion;
   	    }

      public function getF_estado(){
         return $this->f_estado;
      }

      public function setF_estado($f_estado){
         $this->f_estado = $f_estado;
      }

      public function getF_fecha_sistema(){
         return $this->f_fecha_sistema;
      }

      public function setF_fecha_sistema($f_fecha_sistema){
         $this->f_fecha_sistema = $f_fecha_sistema;
      }

      public function getF_usuario_inactivacion(){
         return $this->f_usuario_inactivacion;
      }

      public function setF_usuario_inactivacion($f_usuario_inactivacion){
         $this->f_usuario_inactivacion = $f_usuario_inactivacion;
      }

      public function getF_fecha_inactivacion(){
         return $this->f_fecha_inactivacion;
      }

      public function setF_fecha_inactivacion($f_fecha_inactivacion){
         $this->f_fecha_inactivacion = $f_fecha_inactivacion;
      }

      public function getF_fecha_activacion(){
         return $this->f_fecha_activacion;
      }

      public function setF_fecha_activacion($f_fecha_activacion){
         $this->f_fecha_activacion = $f_fecha_activacion;
      }

      public function getF_usuario_activacion(){
         return $this->f_usuario_activacion;
      }

      public function setF_usuario_activacion($f_usuario_activacion){
         $this->f_usuario_activacion = $f_usuario_activacion;
      }


      ////////Datos de Acceso///////////////

       /**************************************/
    public function getIdAcceso(){
            return $this->id_acceso;
        }
    public function setIdAcceso($id_acceso){
            $this->id_acceso = $id_acceso;
        }

    /****************************************/

    public function getTipoAcceso()
    {
        return $this->tipo_acceso;
    }
    
    public function setTipoAcceso($tipo_acceso)
    {
        $this->tipo_acceso = $tipo_acceso;
        return $this;
    }

   
    public function getUsuario(){ //**************************
        return $this->usuario;//**************************
    }
    public function setUsuario($usuario){//**************************
        $this->usuario = $usuario;//**************************
    }
     
     /***********************************/
    
    public function getClave(){
        return $this->clave;
    }
    public function setClave($clave){
        $this->clave = $clave;
    }

    /***********************************/

    
    public function getFechaRegistro(){
        return $this->fecha_registro;
    }
    public function setFechaRegistro($fecha_registro){
        $this->fecha_registro = $fecha_registro;
    }

    /********************************/

    public function getEstadosA()
    {
        return $this->estadosA;
    }
    
    public function setEstadosA($estadosA)
    {
        $this->estadosA = $estadosA;
        return $this;
    }

   
    /********************************/
    
    public function getFechaInactivacion(){
        return $this->fecha_inactivacion;
    }
    public function setFechaInactivacion($fecha_inactivacion){
        $this->fecha_inactivacion = $fecha_inactivacion;
    }
    
    /////////Fin datos de acceso////////////


    ///////Tipos de Acceso//////////

    public function getId_accesos(){
        return $this->id_accesos;
    }
    public function setId_accesos($id_accesos){
        $this->id_accesos = $id_accesos;
        }


      public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
        } 

    
    public function getF_ticket()
    {
        return $this->ticket;
    }
    
    public function setF_ticket($ticket)
    {
        $this->ticket = $ticket;
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
        ///////descripcion que se da en la activar o inactivar un funcionarios////
    public function getDescripcionFinal(){ 
        return $this->descripcionFinal;
    }
    public function setDescripcionFinal($descripcionF){
        $this->descripcionFinal = $descripcionF;
    } 

    public function setCentroCostos($centroCostos){ $this->centroCostos = $centroCostos;}
    public function getCentroCostos(){return $this->centroCostos;}


    public function setDepartamentoInterno($departamento_interno){ $this->departamento_interno = $departamento_interno;}
    public function getDepartamentoInterno(){return $this->departamento_interno;}


}

 ?>