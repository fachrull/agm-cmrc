<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<br><a href="<?=site_url('auth/regis');?>" class="btn btn-oldblue"><i class="fa fa-plus"></i>Store</a><br>
<br>
<table class="table">
  <thead>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Phone</th>
    <th>Detail</th>
  </thead>
  <tbody>
    <?php foreach($posts as $post): ?>
      <tr>
        <td><?= $post['first_name'];?></td>
        <td><?= $post['last_name'];?></td>
        <td><?= $post['phone'];?></td>
        <td><a href="#" type="submit" class="btn btn-oldblue text-white">Detail</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>