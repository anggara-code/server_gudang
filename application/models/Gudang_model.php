<?php 

class Gudang_model extends CI_model {

    public function getGudang($id_gudang = null)
    {
        if($id_gudang === null) {
            // mengembalikan nilai array assocciative
            return $this->db->get('gudang')->result_array();
        } else {
            return $this->db->get_where('gudang', ['id_gudang' => $id_gudang])->result_array();
        }
    }

    public function deleteGudang($id_gudang = null)
    {
        $this->db->delete('gudang', ['id_gudang' => $id_gudang]);
        return $this->db->affected_rows();
    }

    public function createGudang($data)
    {
        $this->db->insert('gudang', $data);
        return $this->db->affected_rows();
    }

    public function updateGudang($data, $id_gudang)
    {
        $this->db->update('gudang', $data, ['id_gudang' => $id_gudang]);
        return $this->db->affected_rows();
    }
}

?>