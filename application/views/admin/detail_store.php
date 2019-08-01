<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?= $post['company_name'];?>
    </h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header pb-0">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>Email</th>
                  <td><?= $prime[0]['email'];?></td>
                </tr>
                <tr>
                  <th>Address</th>
                  <td class="word-wrap"><?= $post['address'];?></td>
                </tr>
                <tr>
                  <th>Address 2</th>
                  <td class="word-wrap"><?php echo ($post['address2'] == NULL? "-" : $post['address2']); ?></td>
                </tr>
                <tr>
                  <th>Province</th>
                  <td><?= $post['province'];?></td>
                </tr>
                <tr>
                  <th>City</th>
                  <td><?= $post['city'];?></td>
                </tr>
                <tr>
                  <th>Sub district</th>
                  <td><?= $post['sub_district'];?></td>
                </tr>
                <tr>
                  <th>Postcode</th>
                  <td><?= $post['postcode'];?></td>
                </tr>
                <tr>
                  <th>Phone 1</th>
                  <td><?php echo ($post['phone1'] == NULL? "-" : $post['phone1']);?></td>
                </tr>
                <tr>
                  <th>Fax</th>
                  <td><?php echo ($post['fax'] == NULL? "-" : $post['fax']);?></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="box-body">
            <hr>
          <a href="<?= site_url('admin/addCluster/'.$post['id'])?>"><button class="btn btn-default btn-oldblue pull-right"><i class="fa fa-plus"></i> Add Cluster</button></a>
          <hr class="mt-80" style="width:100%; height:0px">
          <table id="dataTable1" class="table table-bordered table-striped">
              <thead>
                <th>No.</th>
                <th>Provinsi</th>
                <th>Kabupaten</th>
                <th>Kecamatan</th>
                <th>Action</th>
              </thead>
              <tbody>
                    <?php if ($clusters != NULL): ?>
                      <?php $no = 1;foreach ($clusters as $cluster): ?>
                        <tr>
                          <td><?= $no.'.'?></td>
                          <td><?= $cluster['prov_name']?></td>
                          <td><?= $cluster['city_name']?></td>
                          <td><?= $cluster['sub_name']?></td>
                          <td>
                            <a href="<?= site_url('admin/deleteCluster_Store/'.$post['id'].'/'.$cluster['sub_district'])?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                              <i class="fa fa-trash"></i>
                            </a>
                          </td>
                        </tr>
                      <?php $no++;endforeach; ?>
                    <?php endif; ?>
              </tbody>
            </table>
            <hr>
            <a href="<?= site_url('admin/storeProd/'.$post['id']);?>"><button class="btn btn-default btn-oldblue pull-right"><i class="fa fa-plus"></i> Add Product</button></a>
            <hr class="mt-80" style="width:100%; height:0px">
                <table id="dataTable" class="table table-bordered table-striped">
                  <thead>
                    <th>No.</th>
                    <th>Product</th>
                    <th id="sizeProduct">Size</th>
                    <th>Stock Awal</th>
                    <th>Stock Akhir</th>
                    <th>Inbound</th>
                    <th>Outbound</th>
                    <th>Postpone</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php if($products != NULL): ?>
                      <?php $no=1; ?>
                      <?php foreach($products as $product): ?>
                        <tr>
                          <td><?= $no;?></td>
                          <td><?= $product['product_name'];?></td>
                          <td><?=$product['size_name'];?> (<?= $product['size']; ?>)</td>
                          <td><?= ($product['stock_awal'] != NULL? $product['stock_awal']:'0');?></td>
                          <td><?= ($product['stock_akhir'] != NULL? $product['stock_akhir']:'0');?></td>
                          <td><?= ($product['inbound'] != NULL? $product['inbound']:'0');?></td>
                          <td><?= ($product['outbound'] != NULL? $product['outbound']:'0');?></td>
                          <td><?= ($product['postpone'] != NULL? $product['postpone']:'0');?></td>
                          <td>
                            <a href="<?= site_url('admin/deleteStoreProd/'.$post['id'].'/'.$product['id'])?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php $no++; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
                <hr>
              <a href="<?= site_url('admin/addStore_SpecialPackage/'.$post['id'])?>">
                <button class="btn btn-default btn-oldblue pull-right">
                  <i class="fa fa-plus"></i> Add Special Package
                </button>
              </a>
              <hr class="mt-80" style="width:100%; height:0px;">
              <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                  <th>No.</th>
                  <th>Special Package</th>
                  <th>Stock Awal</th>
                  <th>Stock Akhir</th>
                  <th>Inbound</th>
                  <th>Outbound</th>
                  <th>Postpone</th>
                  <th>Action</th>
                </thead>
                <tbody>

                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
