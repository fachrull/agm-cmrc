<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Super admin and admin controller
 */
class Admin extends CI_Controller {

  function __construct(){
    parent::__construct();

    $this->load->helper('url');
    $this->load->model('Madmin', 'madmin');
  }
  
  public function listAdmin($link = FALSE){
      if ($this->session->userdata('uType') == 1) {
        if ($link === FALSE) {
          $data['posts'] = $this->madmin->getProducts(NULL, NULL, 'tm_super_admin', FALSE);

          $this->load->view('include/admin/header');
          $this->load->view('include/admin/left-sidebar');
          $this->load->view('admin/home_admin', $data);
          $this->load->view('include/admin/footer');
        }else{
          $this->load->view('include/header2');
          echo "<h1>This feature will be updated soon.</h1>";
          $this->load->view('include/footer');
        }
      }
  }
  
  
  public function listStoreOwner(){
      if ($this->session->userdata('uType') == 1) {
          $data['posts'] = $this->madmin->joinDetailStore();

          $this->load->view('include/admin/header');
          $this->load->view('include/admin/left-sidebar');
          $this->load->view('admin/listStoreOwner', $data);
          $this->load->view('include/admin/footer');
      }else{
       $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');   
      }
  }

  public function sa_brand($link = FALSE, $add = FALSE){
    if ($this->session->userdata('uType') == 1) {
      $data['brands'] = $this->madmin->getProducts(NULL, NULL, 'tm_brands', FALSE);

      $this->load->view('include/admin/header');
      $this->load->view('include/admin/left-sidebar');
      $this->load->view('admin/sa_brand', $data);
      $this->load->view('include/admin/footer');

    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function addBrand(){
    if ($this->session->userdata('uType') == 1) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('items', 'Brand', 'required|callback_checkingBrand');
      $this->form_validation->set_rules('desc', 'Description', 'required');

      if ($this->form_validation->run() == TRUE) {
        $file_name = strtolower('brand-logo-'.$this->input->post('items'));

        $config['upload_path'] = './asset/upload/';
        $config['allowed_types'] = 'jpg|jpeg|png|svg';
        $config['file_name']  = $file_name;

        $this->load->library('upload', $config);
        if (! $this->upload->do_upload('brandPict')) {
          $this->session->set_flashdata('error', $this->upload->display_errors());

          $this->load->view('include/admin/header');
          $this->load->view('include/admin/left-sidebar');
          $this->load->view('admin/addBrands');
          $this->load->view('include/admin/footer');
        }else{
          $pName = $this->upload->data();
          $items = array(
            'name'          => $this->input->post('items'),
            'logo'          => $pName['orig_name'],
            'description'   => $this->input->post('desc'),
            'status' => 1,
          );
          $this->madmin->inputData('tm_brands', $items);
          redirect('admin/sa_brand');
        }
      }else{
        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/addBrands');
        $this->load->view('include/admin/footer');
      }
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function checkingBrand($brand){
    $has_brand = $this->madmin->getProducts(array('name' => $brand),
      array('nameField' => 'name'), 'tm_brands', TRUE);
    if(isset($has_brand)){
      $this->session->set_flashdata('error', 'Brand has already been created');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function activeBrand($brand){
    if($this->session->userdata('uType') == 1){
      $stat = $this->madmin->getProducts(array('id' => $brand), array('statField' => 'status'), 'tm_brands',TRUE);
      if($stat['status'] == 1){
        $items = array('status' => 0);
        $this->madmin->updateData(array('id' => $brand), 'tm_brands', $items);
        redirect('admin/sa_brand', 'refresh');
      }else{
        $items = array('status' => 1);
        $this->madmin->updateData(array('id' => $brand), 'tm_brands', $items);
        redirect('admin/sa_brand', 'refresh');
      }
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function deleteBrand($brand){
    if ($this->session->userdata('uType') == 1) {
      $this->madmin->deleteData(array('id' => $brand), 'tm_brands');
      redirect('admin/sa_brand', 'refresh');
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function sa_cat(){
    if ($this->session->userdata('uType') == 1) {
      $data['categories'] = $this->madmin->getProducts(NULL, NULL, 'tm_category', FALSE);

      $this->load->view('include/admin/header');
      $this->load->view('include/admin/left-sidebar');
      $this->load->view('admin/sa_cat', $data);
      $this->load->view('include/admin/footer');
    }else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function addCat(){
    if ($this->session->userdata('uType') == 1) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('items', 'Category', 'required|callback_checkingCat');
      $this->form_validation->set_rules('desc', 'Description', 'required');

      if ($this->form_validation->run() === FALSE) {
        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/addCats');
        $this->load->view('include/admin/footer');
      }else{
        $items = array(
          'name'        => $this->input->post('items'),
          'description' => $this->input->post('desc'),
          'status'      => 1
        );
        $this->madmin->inputData('tm_category', $items);
        redirect('admin/sa_cat');
      }
    }
  }

  public function checkingCat($category){
    $has_cat = $this->madmin->getProducts(array('name' => $category),
      array('nameField' => 'name'), 'tm_category', TRUE);
    if(isset($has_cat)){
      $this->session->set_flashdata('error', 'Category has already been created');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function activeCat($cat){
    if ($this->session->userdata('uType') == 1) {
      $stat = $this->madmin->getProducts(array('id' => $cat), array('statField' => 'status'), 'tm_category',TRUE);
      if($stat['status'] == 1){
        $items = array('status' => 0);
        $this->madmin->updateData(array('id' => $cat), 'tm_category', $items);
        redirect('admin/sa_cat');
      }else{
        $items = array('status' => 1);
        $this->madmin->updateData(array('id' => $cat), 'tm_category', $items);
        redirect('admin/sa_cat');
      }
    }else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function deleteCat($cat){
    if ($this->session->userdata('uType') == 1) {
      $this->madmin->deleteData(array('id' => $cat), 'tm_category');
      redirect('admin/sa_cat', 'refresh');
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function allProd(){
    if ($this->session->userdata('uType') == 1) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('brand', 'Brand', 'required');
      $this->form_validation->set_rules('cat', 'Category', 'required');

      if ($this->form_validation->run() == FALSE){
        $data['products'] = $this->madmin->allProducts(NULL, NULL, 'tm_product', FALSE);
        $data['brands'] = $this->madmin->getProducts(array('status' => 1), NULL, 'tm_brands', FALSE);
        $data['cats'] = $this->madmin->getProducts(array('status' => 1), NULL, 'tm_category', FALSE);

        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/allProd', $data);
        $this->load->view('include/admin/footer');
      }else{
        $idBrand = $this->input->post('brand');
        $idCat = $this->input->post('cat');
        if ($idBrand != 0 && $idCat != 0) {
          $data['products'] = $this->madmin->allProducts(array('brand_id' => $idBrand,
          'cat_id' => $idCat), NULL, 'tm_product', FALSE);
        }elseif($idBrand != 0 && $idCat == 0){
          $data['products'] = $this->madmin->allProducts(array('brand_id' => $idBrand), NULL, 'tm_product', FALSE);
        }elseif ($idBrand == 0 && $idCat != 0) {
          $data['products'] = $this->madmin->allProducts(array('cat_id' => $idCat), NULL, 'tm_product', FALSE);
        }elseif ($idBrand == 0 && $idCat == 0) {
          $data['products'] = $this->madmin->allProducts(NULL, NULL, 'tm_product', FALSE);
        }
        $data['brands'] = $this->madmin->getProducts(array('status' => 1), NULL, 'tm_brands', FALSE);
        $data['cats'] = $this->madmin->getProducts(array('status' => 1), NULL, 'tm_category', FALSE);

        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/allProd', $data);
        $this->load->view('include/admin/footer');
      }
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function addProd(){
    if ($this->session->userdata('uType') == 1) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('brand', 'Brand', 'required');
      // $this->form_validation->set_rules('cat', 'Category', 'required');
      $this->form_validation->set_rules('pName', 'Product Name', 'required');
      $this->form_validation->set_rules('desc', 'Description', 'required');
      $this->form_validation->set_rules('spec[]', 'Specification', 'required');
      $this->form_validation->set_rules('size[]', 'Size', 'required');
      $this->form_validation->set_rules('price[]', 'Price', 'required');

      if ($this->form_validation->run() === TRUE) {
        $bName = $this->madmin->getProducts(array('id' => $this->input->post('brand')),
          array('nameField' => 'name'), 'tm_brands', TRUE);
        $cName = $this->madmin->getProducts(array('id' => $this->input->post('cat')),
          array('nameField' => 'name'), 'tm_category', TRUE);
        $file_name = strtolower($bName['name'].'-'.$cName['name'].'-'.$this->input->post('pName'));

        $config['upload_path'] = './asset/upload/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['file_name']  = $file_name;

        $this->load->library('upload',$config);
        if(! $this->upload->do_upload('productPict')){
          $data['brands'] = $this->madmin->getProducts(array('status' => 1), array('idField' => 'id',
            'nameField' => 'name'), 'tm_brands', FALSE);
          $data['cats'] = $this->madmin->getProducts(array('status' => 1), array('idField' => 'id',
            'nameField' => 'name'), 'tm_category', FALSE);
          $data['specs'] = $this->madmin->getProducts(array('status' => 1), array('idField' => 'id',
            'nameField' => 'name'), 'tm_spec', FALSE);
          $data['sizes'] = $this->madmin->getProducts(array('status' => 1), array('idField' => 'id',
            'nameField' => 'name', 'sizeField' => 'size'), 'tm_size', FALSE);

          $this->session->set_flashdata('error', $this->upload->display_errors());

          $this->load->view('include/admin/header');
          $this->load->view('include/admin/left-sidebar');
          $this->load->view('admin/addProd', $data);
          $this->load->view('include/admin/footer');
        }else {
          // $data = array('upload_data' => $this->upload->data());
          $pName = $this->upload->data();

          // data for input tm_product
          $items = array(
            'brand_id'    => $this->input->post('brand'),
            'cat_id'      => $this->input->post('cat'),
            'name'        => $this->input->post('pName'),
            'description' => $this->input->post('desc'),
            'image'       => $pName['orig_name'],
            'created_at'  => date('Ymd')
          );

          // input data above to database
          $this->madmin->inputData('tm_product', $items);

          // select id from product
          $prod = $this->madmin->getProducts(array('name' => $this->input->post('pName')),
            array('idField' => 'id'), 'tm_product', TRUE);

          // input for each spec id
          $data = array('spec' => $this->input->post('spec[]'));
          foreach($data['spec'] as $spec){
            $prodSpec = array(
              'prod_id' => $prod['id'],
              'spec_id' => $spec
            );
            $this->madmin->inputData('tr_product_spec', $prodSpec);
          }

          // input for each size and price
          $count_SizePrice = count($this->input->post('size[]'));
          $data_SizePrice = array(
            'size' => $this->input->post('size[]'),
            'price' => $this->input->post('price[]')
          );
          for ($i=0; $i < $count_SizePrice; $i++) {
            $prodSizePrice = array(
              'prod_id' => $prod['id'],
              'size_id' => $data_SizePrice['size'][$i],
              'price'   => $data_SizePrice['price'][$i]
            );
            // input size and price
            $this->madmin->inputData('tr_product_size', $prodSizePrice);
          }
          redirect('admin/allProd');
        }
      }else{
        $data['brands'] = $this->madmin->getProducts(array('status' => 1), array('idField' => 'id',
          'nameField' => 'name'), 'tm_brands', FALSE);
        $data['cats'] = $this->madmin->getProducts(array('status' => 1), array('idField' => 'id',
          'nameField' => 'name'), 'tm_category', FALSE);
        $data['specs'] = $this->madmin->getProducts(array('status' => 1), array('idField' => 'id',
          'nameField' => 'name'), 'tm_spec', FALSE);
        $data['sizes'] = $this->madmin->getProducts(array('status' => 1), array('idField' => 'id',
          'nameField' => 'name', 'sizeField' => 'size'), 'tm_size', FALSE);

        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/addProd', $data);
        $this->load->view('include/admin/footer');
      }
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function test($idProduct, $idDistrict){
    $data = $this->madmin->checkStock_by_Distcit($idProduct, $idDistrict);
    print_r($data);
  }

  public function detailProd($idProd){
    if ($this->session->userdata('uType') == 1) {
      $specs = [];
      $prices = [];
      $sizes = [];
      $data['product'] = $this->madmin->getProducts(array('id' => $idProd), NULL, 'tm_product', TRUE);
      $data['brand'] = $this->madmin->getProducts(array('id' => $data['product']['brand_id']),
       array('nameField' => 'name'), 'tm_brands', TRUE);
      $data['category'] = $this->madmin->getProducts(array('id' => $data['product']['cat_id']),
       array('nameField' => 'name'), 'tm_category', TRUE);
      $idSpec = $this->madmin->getProducts(array('prod_id' => $idProd),
       array('idField' => 'spec_id'), 'tr_product_spec', FALSE);
      $idSize = $this->madmin->getProducts(array('prod_id' => $idProd),
       array('idField' => 'size_id', 'priceField' => 'price'), 'tr_product_size', FALSE);

      for ($i=0; $i < count($idSpec) ; $i++) {
        array_push($specs, $this->madmin->getProducts(array('id' => $idSpec[$i]['spec_id']),
         array('nameField' => 'name'), 'tm_spec', TRUE));
      }
      $data['specs'] = $specs;

      for ($i=0; $i < count($idSize); $i++) {
        array_push($prices, $idSize[$i]['price']);
      }
      $data['prices'] = $prices;

      for ($i=0; $i < count($idSize); $i++) {
        array_push($sizes, $this->madmin->getProducts(array('id' => $idSize[$i]['size_id']),
         array('nameField' => 'name', 'sizeField' => 'size'), 'tm_size', FALSE));
      }
      $data['sizes'] = $sizes;

      $this->load->view('include/admin/header');
      $this->load->view('include/admin/left-sidebar');
      $this->load->view('admin/prodDetail', $data);
      $this->load->view('include/admin/footer');
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }

  }

  public function deleteProd($idProd){
    if ($this->session->userdata('uType') == 1) {
      $this->madmin->deleteData(array('id' => $idProd), 'tm_product');
      $this->madmin->deleteData(array('prod_id' => $idProd), 'tr_product_size');
      $this->madmin->deleteData(array('prod_id' => $idProd), 'tr_product_spec');
      redirect('admin/allProd');
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function sa_agmpedia(){
    if ($this->session->userdata('uType') == 1) {
      $data['pedias'] = $this->madmin->getProducts(NULL, NULL, 'tm_agmpedia', FALSE);

      $this->load->view('include/admin/header');
      $this->load->view('include/admin/left-sidebar');
      $this->load->view('admin/sa_agmpedia', $data);
      $this->load->view('include/admin/footer');
    }else {
        $this->load->view('include/header2');
        $this->load->view('un-authorise');
        $this->load->view('include/footer');
    }
  }

  public function addPedia(){
    if ($this->session->userdata('uType') == 1) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('sContent', 'Sub news', 'required|max_length[125]');
      $this->form_validation->set_rules('content', 'News', 'required');

      if ($this->form_validation->run() === TRUE) {
        $config['upload_path'] = './asset/upload/pedia/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);
        if ( empty($this->upload->do_upload('photo')) || empty($this->upload->do_upload('thumbnail')) ) {
          $this->session->set_flashdata('error', $this->upload->display_errors());

          $this->load->view('include/admin/header');
          $this->load->view('include/admin/left-sidebar');
          $this->load->view('admin/addPedia');
          $this->load->view('include/admin/footer');
        }else{
          $this->upload->do_upload('photo');
          $photos = $this->upload->data();
          $this->upload->do_upload('thumbnail');
          $thumbnails = $this->upload->data();

          $items = array(
            'title' => $this->input->post('title'),
            'sub_content' => $this->input->post('sContent'),
            'content' => $this->input->post('content'),
            'date'  => date('Ymd'),
            'thumbnail' => $thumbnails['orig_name'],
            'photo' => $photos['orig_name'],
            'status' => 1,
            'user_id' => $this->session->userdata('uId')
          );
          $this->madmin->inputData('tm_agmpedia', $items);
          redirect('admin/sa_agmpedia');
        }
      } else {
        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/addPedia');
        $this->load->view('include/admin/footer');
      }
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function storeProd($idSO){
    if ($this->session->userdata('uType') == 2 || $this->session->userdata('uType') == 1) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('product', 'Product', 'required|callback_checkingSProd');

      if ($this->form_validation->run() === FALSE) {
           $idStore = array('idStore' => $idSO);
           $data['storeId'] = $idStore;
        $data['products'] = $this->madmin->getProducts(NULL, array('idField' => 'id', 'nameField' => 'name'),
         'tm_product', FALSE);

         $this->load->view('include/admin/header');
         $this->load->view('include/admin/left-sidebar');
         $this->load->view('admin/storeProd', $data);
         $this->load->view('include/admin/footer');
       }else{
         // input for each size and price
          $count_SizePrice = count($this->input->post('size[]'));
          $data_SizePrice = array(
            'size' => $this->input->post('size[]'),
          );
          for ($i=0; $i < $count_SizePrice; $i++) {
            $prodSizePrice = array(
              'id_store'           => $idSO,
              'id_product'         => $this->input->post('product'),
              'id_product_size'    => $data_SizePrice['size'][$i],
              'new'                => 1,
              'id_admin'           => $this->session->userdata('uId')
            );
            // input size and price
            $this->madmin->inputData('tr_product', $prodSizePrice);
          }
         redirect('admin/stores/'.$idSO);
       }
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }
  
  public function getIdProduct($idProd){
      $sizes = $this->madmin->joinSizeProduct($idProd);
       if($sizes) {
        print_r(json_encode($sizes));
    } else {
        echo "Something went wrong";
    }
  }

  public function checkingSProd($prod){
    $alreadyAssgn = $this->madmin->getProducts(array('id_product' => $prod, 'id_store' => $this->input->post('idStore')),
     NULL, 'tr_product', TRUE);
    if (isset($alreadyAssgn)) {
      $this->session->set_flashdata('error', 'Product has already been added to store');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function addQuan(){
    if ($this->session->userdata('uType') == 2) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('quan', 'Quantity', 'required');

      $data['quantity'] = $this->madmin->getProducts(array('id' => $this->session->userdata('idProd')),
        array('quantityField' => 'quantity'), 'tm_product', TRUE);

      if ($this->form_validation->run() == FALSE) {
        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/prodQuantity', $data);
        $this->load->view('include/admin/footer');
      }else{
        if ($this->input->post('quan') > $data['quantity']) {
          $this->session->set_flashdata('error', 'Quantity must be at least same from current quantity');
          $this->load->view('include/admin/header');
          $this->load->view('include/admin/left-sidebar');
          $this->load->view('admin/prodQuantity', $data);
          $this->load->view('include/admin/footer');
        }else{
          $items = array(
            'id_store' => $this->session->userdata('idStore'),
            'id_product' => $this->session->userdata('idProd'),
            'quantity' => $this->input->post('quan'),
            'id_admin' => $this->session->userdata('uId')
          );
          $this->madmin->inputData('tr_product', $items);
          $newQuan = $data['quantity'] - $this->input->post('quan');
          $new_quantity = array(
            'quantity' => $newQuan
          );
          $this->madmin->updateData(array('id' => $this->session->userdata('idProd')),
            'tr_product', $new_quantity);
          $this->session->unset_userdata('idProd');
          $this->session->unset_userdata('idStore');
          redirect();
        }
      }
    }else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function sa_slider(){
    if ($this->session->userdata('uType') == 1) {
      $data['slides'] = $this->madmin->getProducts(NULL, NULL, 'tm_slide', FALSE);

      $this->load->view('include/admin/header');
      $this->load->view('include/admin/left-sidebar');
      $this->load->view('admin/sa_slider', $data);
      $this->load->view('include/admin/footer');
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function addSlider(){
    if ($this->session->userdata('uType') == 1) {

      $config['upload_path'] = './asset/upload/';
      $config['allowed_types'] = 'jpg|jpeg|png';

      $this->load->library('upload', $config);

      if (! $this->upload->do_upload('sliderPict')) {
        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/addSlider');
        $this->load->view('include/admin/footer');
      }else{
        $pName = $this->upload->data();
        $items = array(
          'slide'       => $pName['orig_name'],
          'created_at'  => date('Ymd'),
        );
        $this->madmin->inputData('tm_slide', $items);
        redirect('admin/sa_slider');
      }
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function deleteSlider($idSlider){
    if ($this->session->userdata('uType') == 1) {
      $this->madmin->deleteData(array('id' => $idSlider), 'tm_slide');
      redirect('admin/sa_slider');
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function sa_spec(){
    if ($this->session->userdata('uType') == 1) {
      $data['specs'] = $this->madmin->getProducts(NULL, NULL, 'tm_spec', FALSE);

      $this->load->view('include/admin/header');
      $this->load->view('include/admin/left-sidebar');
      $this->load->view('admin/sa_spec', $data);
      $this->load->view('include/admin/footer');
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function addSpec(){
    if ($this->session->userdata('uType') == 1) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('name', 'Spec name', 'required|callback_checkingSpec');

      if ($this->form_validation->run() === TRUE) {
        // $file_name = strtolower('spec-'.$this->input->post('name'));
        //
        // $config['upload_path'] = './asset/upload/';
        // $config['allowed_types'] = 'jpg|jpeg|png';
        // $config['file_name'] = $file_name;
        //
        // $this->load->library('upload', $config);
        // if (! $this->upload->do_upload('specPict')) {
        //   $this->session->set_flashdata('error', $this->upload->display_errors());
        //
        //   $this->load->view('include/admin/header');
        //   $this->load->view('include/admin/left-sidebar');
        //   $this->load->view('admin/addSpec');
        //   $this->load->view('include/admin/footer');
        // }else{
        //   $pName = $this->upload->data();

          $items = array(
            'name'        => $this->input->post('name'),
            // 'image'       => $pName['orig_name'],
            'created_at'  => date('Ymd')
          );
          $this->madmin->inputData('tm_spec', $items);
          redirect('admin/sa_spec');
        // }
      }else{
        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/addSpec');
        $this->load->view('include/admin/footer');
      }
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function checkingSpec($spec){
    $specName = $this->madmin->getProducts(array('name' => $spec), array('nameField' => 'name'), 'tm_spec', TRUE);

    if(isset($specName)){
      $this->session->set_flashdata('error', 'Spec has already been created');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function deleteSpec($specId){
    if ($this->session->userdata('uType') == 1) {
      $this->madmin->deleteData(array('id' => $specId), 'tm_spec');
      redirect('admin/sa_spec');
    }else{
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function sa_size(){
    if ($this->session->userdata('uType') == 1) {
      $data['sizes'] = $this->madmin->getProducts(NULL, NULL,'tm_size', FALSE);

      $this->load->view('include/admin/header');
      $this->load->view('include/admin/left-sidebar');
      $this->load->view('admin/sa_size', $data);
      $this->load->view('include/admin/footer');
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }

  }

  public function addSize(){
    if ($this->session->userdata('uType') == 1) {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('name', 'Size name', 'required|callback_checkingSizeName');
      $this->form_validation->set_rules('size', 'Size', 'required|callback_checkingSize');

      if ($this->form_validation->run() === FALSE) {
        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/addSize');
        $this->load->view('include/admin/footer');
      }else{
        $items = array(
          'name'       => $this->input->post('name'),
          'size'       => $this->input->post('size'),
          'created_at' => date('Ymd'),
          'status'     => 1
        );
        $this->madmin->inputData('tm_size', $items);
        redirect('admin/sa_size');
      }
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function checkingSizeName($name){
    $sizeName = $this->madmin->getProducts(array('name' => $name), array('nameField' => 'name'), 'tm_size', TRUE);

    if (isset($sizeName)) {
      $this->session->set_flashdata('error', 'Size name has already been created');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function checkingSize($size){
    if ($this->checkingSizeName($this->input->post('name'))) {
      $size = $this->madmin->getProducts(array('size' => $size), array('sizeField' => 'size'), 'tm_size', TRUE);
      if (isset($size)) {
        $this->session->set_flashdata('error', 'Size has already been created');
        return FALSE;
      }else{
        return TRUE;
      }
    }else{
      $this->session->set_flashdata('error', 'Size name has already been created');
      return FALSE;
    }
  }

  public function deleteSize($sizeId){
    if ($this->session->userdata('uType') == 1) {
      $this->madmin->deleteData(array('id' => $sizeId), 'tm_size');
      redirect('admin/sa_size');
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }

  public function stores($link = FALSE){
    if ($this->session->userdata('uType') == 1) {
      if($link === FALSE){
        $data['provinces'] = [];
        $data['cities'] = [];
        $data['sub_districts'] = [];
        $data['posts'] = $this->madmin->getProducts(NULL, NULL, 'tm_store_owner', FALSE);
        foreach ($data['posts'] as $store) {
          $provinsi = $this->madmin->joinStoreProv($store['id']);
          $kabupaten = $this->madmin->jointStoreKab($store['id']);
          $kecamatan = $this->madmin->jointStoreKec($store['id']);
          array_push($data['provinces'], $provinsi);
          array_push($data['cities'], $kabupaten);
          array_push($data['sub_districts'], $kecamatan);
        }
        
        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/stores', $data);
        $this->load->view('include/admin/footer');
      } else {
        $idStore = array('idStore' => $link);
        $id = $this->madmin->getProducts(array('id' => $link),
          array('idUserLogin' => 'id_userlogin'), 'tm_store_owner', TRUE);
        $data['post'] = $this->madmin->getProducts(array('id' => $link),NULL, 'tm_store_owner', TRUE);
        $data['prime'] = $this->madmin->emailStore($link);
        $data['storeId'] = $idStore;
        $data['products'] = $this->madmin->joinStoreProd($link);

        $this->load->view('include/admin/header');
        $this->load->view('include/admin/left-sidebar');
        $this->load->view('admin/detail_store', $data);
        $this->load->view('include/admin/footer');
      }
    } else {
      $this->load->view('include/header2');
      $this->load->view('un-authorise');
      $this->load->view('include/footer');
    }
  }
  
  public function bestSeller()
  {
    $this->load->view('include/admin/header');
    $this->load->view('include/admin/left-sidebar');
    $this->load->view('admin/sa_bestseller');
    $this->load->view('include/admin/footer');
  }

  public function sa_promotion()
  {
    $this->load->view('include/admin/header');
    $this->load->view('include/admin/left-sidebar');
    $this->load->view('admin/sa_promotion');
    $this->load->view('include/admin/footer');
  }

  public function sizeNameStore($idSize){
      $sizeName = $this->madmin->getSizeName($idSize);
      if($sizeName) {
        print_r(json_encode($sizeName));
      } else {
        echo "Something went wrong";
      }
  }
  
  public function sizeNameProduct($idSize){
      $sizeName = $this->madmin->getSizeNameProduct($idSize);
      if($sizeName) {
        print_r(json_encode($sizeName));
      } else {
        echo "Something went wrong";
      }
  }
}
