<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use RestServer\RestController;
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

class Api extends RestController {
    
    // function __construct() {
    //     parent::__construct();
    //     $this->load->model('DAO');
    // }

    function pruebas_get() {
        $this->load->model('DAO');

        if ($this->get('id')) {
            $prueba = $this->DAO->seleccionar_entidad('pruebas', array('id' => $this->get('id')), TRUE);

            $respuesta = array(
                "status" => '1',
                "mensaje" => "Informacion cargada correctamente",
                "datos" => $prueba,
                "errores" => array()
            );
        } else {
            $pruebas = $this->DAO->seleccionar_entidad('pruebas');

            $respuesta = array(
                "status" => '1',
                "mensaje" => "Informacion cargada correctamente",
                "datos" => $pruebas,
                "errores" => array()
            );
        }

        $this->response($respuesta, 200);
    }

    function pruebas_post() {
        $this->load->model('DAO');

        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('prueba', 'Prueba', 'required');

        if ( $this->form_validation->run() ) {
            $datos = array(
                "prueba" => $this->post('prueba')
            );

            $respuesta = $this->DAO->insert_modificar_entidad('pruebas', $datos);

            if ($respuesta['status'] == '1') {
                $respuesta = array(
                    "status" => "1",
                    "mensaje" => "Registro Correcto",
                    "datos" => array(),
                    "errores" => array()
                );
            } else {
                $respuesta = array(
                    "status" => "0",
                    "errores" => array(),
                    "mensaje" => "Error al registrar",
                    "datos" => array()
                );
            }

        } else {
            $respuesta = array(
                "status" => "0",
                "errores" => $this->form_validation->error_array(),
                "mensaje" => "Error al procesar la información",
                "datos" => array()
            );
        }

        $this->response($respuesta, 200);
    }

    function pruebas_put() {
        $this->load->model('DAO');

        $this->form_validation->set_data($this->put());
        $this->form_validation->set_rules('titulo', 'Titulo', 'required');
        $this->form_validation->set_rules('duracion', 'Duracion', 'required');
        $this->form_validation->set_rules('precio', 'Precio', 'required');
        $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');

        if ( $this->form_validation->run() ) {
            $datos = array(
                "titulo" => $this->put('titulo'),
                "duracion" => $this->put('duracion'),
                "precio" => $this->put('precio'),
                "descripcion" => $this->put('descripcion')
            );

            $respuesta = $this->DAO->insert_modificar_entidad('pruebas', $datos, array('id' => $this->put('id')));

            if ($respuesta['status'] == '1') {
                $respuesta = array(
                    "status" => "1",
                    "mensaje" => "Actualizado Correcto",
                    "datos" => array(),
                    "errores" => array()
                );
            } else {
                $respuesta = array(
                    "status" => "0",
                    "errores" => array(),
                    "mensaje" => "Error al registrar",
                    "datos" => array()
                );
            }

        } else {
            $respuesta = array(
                "status" => "0",
                "errores" => $this->form_validation->error_array(),
                "mensaje" => "Error al procesar la información",
                "datos" => array()
            );
        }

        $this->response($respuesta, 200);
    }

    function pruebas_delete() {
        $this->load->model('DAO');

        if ($this->input->get('id')) {
            $prueba = $this->DAO->eliminar_entidad('pruebas', $this->input->get('id'));

            $respuesta = array(
                "status" => "1",
                "mensaje" => "Eliminado Correcto",
                "datos" => $prueba,
                "errores" => array(),
                "id" => $this->get('id')
            );
        } else {
            $respuesta = array(
                "status" => "0",
                "mensaje" => "No llega el id",
                "datos" => array(),
                "errores" => array(),
                "id" => $this->input->get('id')
            );
        }
        
        $this->response($respuesta, 200);
    }
}