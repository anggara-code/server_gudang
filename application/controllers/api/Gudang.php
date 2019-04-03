<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        // load model & membuat alias 'gudang'
        $this->load->model('Gudang_model', 'gudang');
    }
    
    public function index_get() {
        $id_gudang = $this->get('id_gudang');

        if($id_gudang === null) {
            $gudang = $this->gudang->getGudang();
        } else {
            $gudang = $this->gudang->getGudang($id_gudang);
        }

        if($gudang) {
            $this->response([
                'status' => TRUE,
                'data' => $gudang
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id_gudang = $this->delete('id_gudang');

        if($id_gudang === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->gudang->deleteGudang($id_gudang) > 0) {
                $this->response([
                    'status' => TRUE,
                    'id_gudang' => $id_gudang,
                    'message' => 'deleted.'
                    // jika HTTP_NO_CONTENT maka response tidak akan di tampilkan, solusi ganti ->  HTTP_OK
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nama_gudang' => $this->post('nama_gudang'),
            'lokasi' => $this->post('lokasi'),
            'kapasitas' => $this->post('kapasitas')
        ];

        if($this->gudang->createGudang($data) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'new gudang has been created'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id_gudang = $this->put('id_gudang');
        $data = [
            'nama_gudang' => $this->put('nama_gudang'),
            'lokasi' => $this->put('lokasi'),
            'kapasitas' => $this->put('kapasitas')
        ];

        if($this->gudang->updateGudang($data, $id_gudang) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'gudang has been updated'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}

?>