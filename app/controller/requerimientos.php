<?php
    //require('../model/crud_peticiones.php');
    require_once('../model/datos_peticionesmai.php');
    require_once('../model/datos_peticion.php');
    require_once("../model/vinculo.php");
    
    $datos= new Peticion();
        
        if(isset($_POST['btn-consultarFechaI'])){
            
    
            $inicio = date('Y-m-d 00:00:00', strtotime($_POST['fechaInicial']));
            $final = date('Y-m-d 23:59:59', strtotime($_POST['fechaFinal']));
    
            $db=conectar::acceso();
            $listaConsulta=[];

            $db=conectar::acceso();
            $listaConsulta=[];
            $seleccion=$db->prepare('SELECT  id_peticionmai, estado.descripcion AS estado, DATE_FORMAT(fecha_peticion,"%d-%m-%Y %H:%i"),DATE_FORMAT(fecha_atencion,"%d-%m-%Y %H:%i"), usuario_creacion, productos_mai.nombre_producto, descripcion_peticion, usuario_atencion, conclusiones,nivel_encuesta,imagen, req_nombre , req_justificacion, sprint, gestion, tipo_soportemai, tipo_soportemai.nombre, tipo_soportemai.id
            as nombre_categoria
            FROM peticiones_mai LEFT JOIN productos_mai ON id_producto = producto_mai 
            LEFT JOIN estado ON estado.id_estado=peticiones_mai.estado_peticion
            left join tipo_soportemai on tipo_soportemai.id = peticiones_mai.tipo_soportemai
            WHERE tipo_soportemai=:tipo_soportemai AND fecha_peticion BETWEEN :fechaInicial AND :fechaFinal 
            AND (estado_peticion=:estadoN OR estado_peticion=:estadoD OR estado_peticion=:estadoP OR estado_peticion=:estadoC 
            OR estado_peticion=:estadoS OR estado_peticion=:estadoE)');
            $seleccion->bindValue('estadoN','1');
            $seleccion->bindValue('estadoD','2');
            $seleccion->bindValue('estadoP','3');
            $seleccion->bindValue('estadoC','4');
            $seleccion->bindValue('estadoE','18');
            $seleccion->bindValue('tipo_soportemai','2');
            $seleccion->bindValue('estadoS','8');
            $seleccion->bindValue('fechaInicial',$inicio);
            $seleccion->bindValue('fechaFinal',$final);
            $seleccion->execute();
        
            foreach($seleccion->fetchAll() as $listado){
                $consulta= new Peticion();
                $consulta->setP_estado($listado['estado']);
                $consulta->setP_nropeticion($listado['id_peticionmai']);       
                $consulta->setP_fechapeticion($listado['DATE_FORMAT(fecha_peticion,"%d-%m-%Y %H:%i")']);
                $consulta->setP_usuario($listado['usuario_creacion']);
                $consulta->setP_categoria($listado['nombre_producto']);
                $consulta->setP_descripcion($listado['descripcion_peticion']);
                $consulta->setP_fechaatendido($listado['DATE_FORMAT(fecha_atencion,"%d-%m-%Y %H:%i")']);   
                $consulta->setP_usuarioatiende($listado['usuario_atencion']);
                $consulta->setP_conclusiones($listado['conclusiones']);
                $consulta->setCalificacion($listado['nivel_encuesta']);
                $consulta->setP_cargarimagen($listado['imagen']);
                $consulta->setReq_nombre($listado['req_nombre']);
                $consulta->setReq_justificacion($listado['req_justificacion']);
                $consulta->setSprint($listado['sprint']);
                $consulta->setGestion(($listado['gestion']));
                $consulta->setName($listado['nombre']); 
                $listaConsulta[]=$consulta;    
                 
            }
        }elseif (isset($_POST['btn-consultarTicketI'])) {
            
            $db = conectar::acceso();
            $listaConsulta = [];
            
            $seleccion = $db->prepare('SELECT id_peticionmai, estado.descripcion AS estado, DATE_FORMAT(fecha_peticion,"%d-%m-%Y %H:%i") AS fecha_peticion, 
            DATE_FORMAT(fecha_atencion,"%d-%m-%Y %H:%i") AS fecha_atencion, usuario_creacion, productos_mai.nombre_producto, descripcion_peticion, usuario_atencion, 
            conclusiones, nivel_encuesta, imagen, req_nombre, req_justificacion, sprint, gestion, tipo_soportemai, tipo_soportemai.nombre, tipo_soportemai.id
            as nombre_categoria
                FROM peticiones_mai 
                LEFT JOIN productos_mai ON id_producto = producto_mai 
                LEFT JOIN estado ON estado.id_estado = peticiones_mai.estado_peticion
                LEFT JOIN tipo_soportemai ON tipo_soportemai.id = peticiones_mai.tipo_soportemai
                WHERE id_peticionmai = :numero_peticion');
            
            $seleccion->bindValue('numero_peticion',$_POST['peticionFiltro']);
            $seleccion->execute();
            
            foreach ($seleccion->fetchAll() as $listado) {
                $consulta = new Peticion();
                $consulta->setP_estado($listado['estado']);
                $consulta->setP_nropeticion($listado['id_peticionmai']);
                $consulta->setP_fechapeticion($listado['fecha_peticion']);
                $consulta->setP_usuario($listado['usuario_creacion']);
                $consulta->setP_categoria($listado['nombre_producto']);
                $consulta->setP_descripcion($listado['descripcion_peticion']);
                $consulta->setP_fechaatendido($listado['fecha_atencion']);
                $consulta->setP_usuarioatiende($listado['usuario_atencion']);
                $consulta->setP_conclusiones($listado['conclusiones']);
                $consulta->setCalificacion($listado['nivel_encuesta']);
                $consulta->setP_cargarimagen($listado['imagen']);
                $consulta->setReq_nombre($listado['req_nombre']);
                $consulta->setReq_justificacion($listado['req_justificacion']);
                $consulta->setSprint($listado['sprint']);
                $consulta->setGestion($listado['gestion']);
                $consulta->setName($listado['nombre']);
                $listaConsulta[] = $consulta;
            }
        }elseif (isset($_POST['btn-consultarEstado'])) {
            $estado = $_POST['estadoFiltro'];
        
            $listaConsulta = [];
        
            $db = conectar::acceso();
            $seleccion = $db->prepare('SELECT id_peticionmai, estado.descripcion AS estado, DATE_FORMAT(fecha_peticion, "%d-%m-%Y %H:%i") AS fecha_peticion, 
            DATE_FORMAT(fecha_atencion, "%d-%m-%Y %H:%i") AS fecha_atencion, usuario_creacion, productos_mai.nombre_producto, descripcion_peticion, 
            usuario_atencion, conclusiones, nivel_encuesta, imagen, req_nombre, req_justificacion, sprint, gestion, tipo_soportemai, tipo_soportemai.nombre, tipo_soportemai.id
             AS nombre_categoria
                FROM peticiones_mai
                LEFT JOIN productos_mai ON id_producto = producto_mai
                LEFT JOIN estado ON estado.id_estado = peticiones_mai.estado_peticion
                LEFT JOIN tipo_soportemai ON tipo_soportemai.id = peticiones_mai.tipo_soportemai
                WHERE tipo_soportemai = :tipo_soportemai AND estado_peticion = :estado');
            $seleccion->bindValue('estado', $_POST['estadoFiltro']);
            $seleccion->bindValue('tipo_soportemai', '2');
            $seleccion->execute();

            foreach ($seleccion->fetchAll() as $listado) {
                    $consulta = new Peticion();
                    $consulta->setP_estado($listado['estado']);
                    $consulta->setP_nropeticion($listado['id_peticionmai']);
                    $consulta->setP_fechapeticion($listado['fecha_peticion']);
                    $consulta->setP_usuario($listado['usuario_creacion']);
                    $consulta->setP_categoria($listado['nombre_producto']);
                    $consulta->setP_descripcion($listado['descripcion_peticion']);
                    $consulta->setP_fechaatendido($listado['fecha_atencion']);
                    $consulta->setP_usuarioatiende($listado['usuario_atencion']);
                    $consulta->setP_conclusiones($listado['conclusiones']);
                    $consulta->setCalificacion($listado['nivel_encuesta']);
                    $consulta->setP_cargarimagen($listado['imagen']);
                    $consulta->setReq_nombre($listado['req_nombre']);
                    $consulta->setReq_justificacion($listado['req_justificacion']);
                    $consulta->setSprint($listado['sprint']);
                    $consulta->setGestion($listado['gestion']);
                    $consulta->setName($listado['nombre']);
                    $listaConsulta[] = $consulta;
                }

        }else if(isset($_POST['btn-consultarusuarioI'])){
            $db = conectar::acceso();
            $seleccion = $db->prepare('SELECT id_peticionmai, estado.descripcion AS estado, DATE_FORMAT(fecha_peticion, "%d-%m-%Y %H:%i") AS fecha_peticion, 
            DATE_FORMAT(fecha_atencion, "%d-%m-%Y %H:%i") AS fecha_atencion, usuario_creacion, productos_mai.nombre_producto, descripcion_peticion, 
            usuario_atencion, conclusiones, nivel_encuesta, imagen, req_nombre, req_justificacion, sprint, gestion, tipo_soportemai, tipo_soportemai.nombre, tipo_soportemai.id
             AS nombre_categoria
                FROM peticiones_mai
                LEFT JOIN productos_mai ON id_producto = producto_mai
                LEFT JOIN estado ON estado.id_estado = peticiones_mai.estado_peticion
                LEFT JOIN tipo_soportemai ON tipo_soportemai.id = peticiones_mai.tipo_soportemai
                WHERE tipo_soportemai=:tipo_soportemai and usuario_creacion=:usuario');
            $seleccion->bindValue('usuario', $_POST['usuarioFiltro']);
            $seleccion->bindValue('tipo_soportemai', '2');
            $seleccion->execute();

            foreach ($seleccion->fetchAll() as $listado) {
                    $consulta = new Peticion();
                    $consulta->setP_estado($listado['estado']);
                    $consulta->setP_nropeticion($listado['id_peticionmai']);
                    $consulta->setP_fechapeticion($listado['fecha_peticion']);
                    $consulta->setP_usuario($listado['usuario_creacion']);
                    $consulta->setP_categoria($listado['nombre_producto']);
                    $consulta->setP_descripcion($listado['descripcion_peticion']);
                    $consulta->setP_fechaatendido($listado['fecha_atencion']);
                    $consulta->setP_usuarioatiende($listado['usuario_atencion']);
                    $consulta->setP_conclusiones($listado['conclusiones']);
                    $consulta->setCalificacion($listado['nivel_encuesta']);
                    $consulta->setP_cargarimagen($listado['imagen']);
                    $consulta->setReq_nombre($listado['req_nombre']);
                    $consulta->setReq_justificacion($listado['req_justificacion']);
                    $consulta->setSprint($listado['sprint']);
                    $consulta->setGestion($listado['gestion']);
                    $consulta->setName($listado['nombre']);
                    $listaConsulta[] = $consulta;
                }
        }
?>