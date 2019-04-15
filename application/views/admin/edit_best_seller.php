<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="content-wrapper">
  <section class="content-header">
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3">
        <div class="box">
          <div class="box-body">
          <h2 class="text-center mb-20">
            <?= $best_seller['name']?>
            </h2>
          <div class="row text-center mb-20">
            <div class="col-xs-12 mb-20">
            <img style="width:100px !important; height:100px;" src="<?= base_url('asset/upload/'.$best_seller['image']);?>">
            </div>
          </div>
          <div class="row mb-20">
            <div class="col-xs-12 mb-20">
              <div class="product-detail">
                <form class="m-0 sky-form" action="<?= site_url('admin/edit_best_seller/'.$best_seller['id'])?>" method="post">
                  <label class="input mb-10">
                    <label for="">Position</label>
                    <input type="number" name="position" value="<?= $best_seller['position']?>" min="1" max="<?= $maxPosition['max']?>" placeholder="Position">
                  </label>
                  <div class="row">
                    <div class="col-md-6">
                      <a href="<?= site_url('admin/bestSeller');?>" class="ml-0 btn btn-oldblue btn-default">Kembali</a>
                    </div>
                    <div class="col-md-6 text-right">
                      <button type="submit" class="btn btn-oldblue btn-default"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
