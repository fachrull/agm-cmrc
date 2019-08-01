<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>Detail Transaksi</h1>
  </section>

    <section class="content">
        <div class="row">
            <div class="col-xs">
                <div class="box">
                    <div class="box-header pb-0">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Nomor Transaksi</th>
                                    <td><?=$detailOrder[0]->order_number;?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <td><?=$detailOrder[0]->order_date;?></td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td class="word-wrap"><?=$detailOrder[0]->first_name." ".$detailOrder[0]->last_name?></td>
                                </tr>
                                <tr>
                                    <th>Alamat Pengiriman</th>
                                    <td class="word-wrap">
                                        <?=$detailOrder[0]->address.", ".$detailOrder[0]->kecamatan.', '.$detailOrder[0]->kabupaten.','.$detailOrder[0]->postcode?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td><?= $detailOrder[0]->phone?></td>
                                </tr>
                                <tr>
                                    <th>Status Transaksi</th>
                                    <td>
                                        <?php
                                        switch($detailOrder[0]->status_order) {
                                            case 1:
                                                echo "<p class=\"label label-success\">Pesanan Selesai</p>";
                                                break;
                                            case 2:
                                                echo "<p class=\"label label-warning btn-sm\">Menunggu Pembayaran</p>";
                                                break;
                                            case 3:
                                                echo "<p class=\"label label-danger btn-sm\">Pesanan Dibatalkan</p>";

                                                break;
                                            case 4:
                                                echo "<p class=\"label label-primary btn-sm\">Pesanan diproses</p>";
                                                break;
                                            case 5:
                                                echo "<p class=\"label label-primary btn-sm\">Pesanan Dikirim</p>";
                                                break;
                                            default:
                                                break;
                                        } ?>

                                    </td>
                                </tr>

                            </table>
                        </div>

                    </div>
                    <table class="table ml-10">
                        <tr>
                            <th>Daftar Produk</th>
                        </tr>
                    </table>
                    <div class="box-body">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                            <th>No.</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Sub price</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($detailOrder as $order): ?>
                                    <tr>
                                        <td><?= $no?></td>
                                        <td><?= $order->name?></td>
                                        <td><?= $order->size_name.' ('.$order->size.')'?></td>
                                        <td><?= $order->quantity?></td>
                                        <td><?= 'Rp '.number_format(floatval($order->subtotal), 0, ',', '.')?></td>
                                    </tr>
                                <?php $no++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>