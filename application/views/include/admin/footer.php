<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.4.0
  </div>
  <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights reserved.
</footer>
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?= base_url('asset/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('asset/bower_components/jquery-ui/jquery-ui.min.js');?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('asset/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- Morris.js charts -->
<script src="<?= base_url('asset/bower_components/raphael/raphael.min.js');?>"></script>
<script src="<?= base_url('asset/bower_components/morris.js/morris.min.js');?>"></script>
<!-- Sparkline -->
<script src="<?= base_url('asset/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js');?>"></script>
<!-- jvectormap -->
<script src="<?= base_url('asset/plugins/jquery-vectormap/jquery-jvectormap-1.2.2.min.js');?>"></script>
<script src="<?= base_url('asset/plugins/jquery-vectormap/jquery-jvectormap-world-mill-en.js');?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('asset/bower_components/jquery-knob/dist/jquery.knob.min.js');?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url('asset/bower_components/moment/min/moment.min.js');?>"></script>
<script src="<?= base_url('asset/bower_components/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<!-- datepicker -->
<script src="<?= base_url('asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url('asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
<!-- Slimscroll -->
<script src="<?= base_url('asset/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
<!-- FastClick -->
<script src="<?= base_url('asset/bower_components/fastclick/lib/fastclick.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('asset/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url('asset/dist/js/pages/dashboard.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('asset/dist/js/demo.js');?>"></script>
<!-- CK Editor -->
<script src="<?= base_url('asset/bower_components/ckeditor/ckeditor.js"');?>"></script>
<!-- DataTables -->
<script src="<?= base_url('asset/bower_components/datatables.net/js/jquery.dataTables.js');?>"></script>
<script src="<?= base_url('asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.js');?>"></script>
<!-- page script -->
<script>
  $(function () {
    $('#dataTable').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'searching'   : true,
      'processing'  : true,
      "dom": '<"top"f>rt<"bottom"ilp><"clear">'
    })
  })
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
  })
</script>
</body>
</html>
