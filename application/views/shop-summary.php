<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?=$midtrans['client_key']?>"></script>

<section class="page-header page-header-md">
  <div class="container">
    <h1>Cart Summary</h1>
  </div>
</section>
<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-sm-5">
        <table class="table">
          <tbody>
            <tr>
              <th>First Name </th>
              <th>:</th>
              <td><?= $address_shipping['first_name']?></td>
            </tr>
            <tr>
              <th>Last Name </th>
              <th>:</th>
              <td><?= $address_shipping['last_name']?></td>
            </tr>
            <tr>
              <th>Address </th>
              <th>:</th>
              <td><?= $address_shipping['address']?></td>
            </tr>
            <tr>
              <th>Province </th>
              <th>:</th>
              <td><?= $address_shipping['provinsi']?></td>
            </tr>
            <tr>
              <th>City </th>
              <th>:</th>
              <td><?= $address_shipping['kabupaten']?></td>
            </tr>
            <tr>
              <th>District </th>
              <th>:</th>
              <td><?= $address_shipping['kecamatan']?></td>
            </tr>
            <tr>
              <th>Postcode </th>
              <th>:</th>
              <td><?= $address_shipping['postcode']?></td>
            </tr>
            <tr>
              <th>Email </th>
              <th>:</th>
              <td><?= $address_shipping['email']?></td>
            </tr>
            <tr>
              <th>Phone </th>
              <th>:</th>
              <td><?= $address_shipping['phone']?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-lg-7 col-sm-7">
        <table class="table toggle-transparent toggle-bordered-full clearfix">
          <thead>
            <tr class="toggle active">
              <div class="toggle-content">
                <th></th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Status</th>
              </div>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($carts as $cart): ?>
              <?php if ($cart['available'] == TRUE): ?>
                <?php if ($cart['type'] == 'special'): ?>
                  <tr class="testimonial">
                    <td>
                      <img class="square" src="<?= site_url('asset/upload/special-package/'.$cart['image']);?>" height="60" alt="<?= $cart['name']?>">
                    </td>
                    <td>
                      <span class="clearfix">
                        <a href="<?= site_url('home/detailSpecial/'. $cart['id'])?>">
                          <span class="float-left"><?= $cart['name']?></span>
                        </a>
                        <br>
												<span><small>Products :</small></span>
                        <ul>
                          <?php foreach ($cart['option'] as $option): ?>
                            <li>
                              <small><?= $option['name'].' - '.$option['nameSize']?> × <?= $option['quantity']?></small>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      </span>
                    </td>
                    <td><span><?= $cart['qty']?></span></td>
                    <td><span class="float-left">Rp <?= number_format($cart['subtotal'], 0,',','.')?></span></td>
                    <td><font color="green"><?= $cart['comment']?></font></td>
                  </tr>
                <?php else: ?>
                  <tr class="testimonial">
                    <td>
                      <img class="square" src="<?= site_url('asset/upload/'.$cart['image']);?>" height="60" alt="<?= $cart['name']?>">
                    </td>
                    <td>
                      <span class="clearfix">
                        <a href="<?= site_url('home/detailProduct/'. $cart['id'])?>">
                          <span class="float-left"><?= $cart['name']?></span>
                        </a>
                        <br>
                        <span class="float-left"><?= $cart['sizeName']?> (<?= $cart['detailSize']?>)</span>
                      </span>
                    </td>
                    <td><span><?= $cart['qty']?></span></td>
                    <td><span class="float-left">Rp <?= number_format($cart['subtotal'],0,',','.')?></span></td>
                    <td><font color="green"><b><?= $cart['comment']?></b></font></td>
                  </tr>
                <?php endif; ?>
              <?php else: ?>
                <?php if ($cart['type'] == 'special'): ?>
                  <tr class="testimonial">
                    <td>
                      <img class="square" src="<?= site_url('asset/upload/special-package/'.$cart['image']);?>" height="60" alt="<?= $cart['name']?>">
                    </td>
                    <td>
                      <span class="clearfix">
                        <a href="<?= site_url('home/detailSpecial/'. $cart['id'])?>">
                          <span class="float-left"><?= $cart['name']?></span>
                        </a>
												<br>
												<span><small>Products :</small></span>
                        <ul>
                          <?php foreach ($cart['option'] as $option): ?>
                            <li>
                              <small><?= $option['name'].' - '.$option['nameSize']?> × <?= $option['quantity']?></small>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      </span>
                    </td>
                    <td><span><?= $cart['qty']?></span></td>
                    <td><span class="float-left">Rp <?= number_format($cart['subtotal'], 0,',','.')?></span></td>
                    <td><font color="green"><?= $cart['comment']?></font></td>
                  </tr>
                <?php else: ?>
                  <tr class="testimonial" style="background: #ffcccc;">
                    <td>
                      <img class="square" src="<?= site_url('asset/upload/'.$cart['image']);?>" height="60" alt="<?= $cart['name']?>">
                    </td>
                    <td>
                      <span class="clearfix">
                        <a href="<?= site_url('home/detailProduct/'.$cart['id'])?>">
                          <span class="float-left"><?= $cart['name']?></span>
                        </a>
                        <br>
                        <span class="float-left"><?= $cart['sizeName']?> (<?= $cart['detailSize']?>)</span>
                      </span>
                    </td>
                    <td><span><?= $cart['qty']?></span></td>
                    <td><span class="float-left">Rp <?= number_format($cart['subtotal'],0,',','.')?></span></td>
                    <td><font color="red"><b><?= $cart['comment']?></b></font></td>
                  </tr>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php if ($available == TRUE): ?>
          <div class="row">
            <div class="col-sm-6 text">
              <a href="<?= site_url('home/deleteCart')?>" class="col-sm-12 btn btn-danger">Cancel</a>
            </div>
            <div class="col-sm-6 text-right">
<!--              <a href="--><?//= site_url('home/purchase')?><!--" class="col-sm-12 btn btn-oldblue">Purchase</a>-->
                <button id="pay-button" class="col-sm-12 btn btn-oldblue">Purchase</button>
            </div>
          </div>
            <div class="row">
                <form id="payment-form" method="post" action="<?=site_url('home/buy')?>">
                    <input type="hidden" name="result_type" id="result-type" value=""></div>
          <input type="hidden" name="result_data" id="result-data" value=""></div>
        </form>
            </div>
        <?php else: ?>
          <div class="row">
            <div class="col-sm-6">
              <a href="<?= site_url('home/shopCart')?>" class="col-sm-12 btn btn-default">Back to Cart</a>
            </div>
            <div class="col-sm-6 text-right">
              <a href="<?= site_url('home/deleteCart')?>" class="col-sm-12 btn btn-danger">Cancel Order</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
