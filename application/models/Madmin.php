<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Super admin and admin controller
 */
class Madmin extends CI_Model {

  function __construct() {
    parent::__construct();

    $this->load->database();
  }

  public function getProducts($condition = NULL, $selection = NULL, $table, $singleRowResult =  FALSE){
    if ($condition != NULL) {
      foreach ($condition as $key => $value) {
        $this->db->where($key, $value);
      }
    }

    if ($selection != NULL) {
      foreach ($selection as $key => $value) {
        $this->db->select($value);
      }
    }

    $query =  $this->db->get($table);

    if ($singleRowResult === TRUE) {
      return $query->row_array();
    }else {
      return $query->result_array();
    }
  }

  public function inputData($table, $items){
    return $this->db->insert($table, $items);
  }

  public function updateData($condition = NULL, $table, $items){
    if ($condition != NULL) {
      foreach ($condition as $key => $value) {
        $this->db->where($key, $value);
      }
    }

    return $this->db->update($table, $items);
  }

  public function deleteData($condition = NULL, $table){
    if ($condition != NULL) {
      foreach ($condition as $key => $value) {
        $this->db->where($key, $value);
      }
    }
    return $this->db->delete($table);
  }

  public function createItems($table){
    $id_creator = $this->session->userdata('uId');
    $items = array(
      'name'            => $this->input->post('items'),
      'id_super_admin'  => $id_creator
    );
    return $this->db->insert($table, $items);
  }

  public function getDataIndex($id = FALSE){
    if($id === FALSE){
      $query = $this->db->get('tm_store_owner');
      return $query->result_array();
    }else{
      $query = $this->db->get_where('tm_store_owner', array('id' => $id));
      return $query->row_array();
    }
  }

  public function dataPrime($id = NULL){
    $this->db->select(array('emailField' => 'email'));
    $query = $this->db->get_where('user_login', array('user_id' =>$id));
    return $query->row_array();
  }

  public function joinStoreProd($store_id){
    $this->db->select('*');
    $this->db->from('tm_product a');
    $this->db->join('tr_product b', 'b.id_product = a.id', 'left');
    $this->db->where('b.id_store', $store_id);
    $query = $this->db->get();
    if($query->num_rows() != 0){
      return $query->result_array();
    }else{
      return FALSE;
    }
  }

  public function joinStoreProv($store_id){
    $this->db->select('a.nama as province');
    $this->db->from('provinsi a');
    $this->db->join('tm_store_owner b', 'b.province = a.id_prov', 'left');
    $this->db->where('b.id', $store_id);
    $query = $this->db->get();
    if($query->num_rows() != 0){
      return $query->result_array();
    }else{
      return FALSE;
    }
  }

  public function jointStoreKab($store_id){
    $this->db->select('a.nama as city');
    $this->db->from('kabupaten a');
    $this->db->join('tm_store_owner b', 'b.city = a.id_kab', 'left');
    $this->db->where('b.id', $store_id);
    $query = $this->db->get();
    if($query->num_rows() != 0){
      return $query->result_array();
    }else{
      return FALSE;
    }
  }

  public function jointStoreKec($store_id){
    $this->db->select('a.nama as sub_district');
    $this->db->from('kecamatan a');
    $this->db->join('tm_store_owner b', 'b.sub_district = a.id_kec', 'left');
    $this->db->where('b.id', $store_id);
    $query = $this->db->get();
    if($query->num_rows() != 0){
      return $query->result_array();
    }else{
      return FALSE;
    }
  }
}
