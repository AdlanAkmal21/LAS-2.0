<!-- jQuery -->
<script src="{{ asset('assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('assets/adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/adminlte/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('assets/adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/adminlte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('assets/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/adminlte/dist/js/adminlte.js') }}"></script>

<!-- --------------------------------------------------------- -->

<!-- Page level custom scripts -->
<script src="{{asset('assets/js/graph/overviewpie.js')}}"></script>
<script src="{{asset('assets/js/graph/individualpie.js')}}"></script>
<script src="{{asset('assets/js/graph/applicationpie.js')}}"></script>

<!-- Masking -->
<script src="{{asset('assets/vendor/masking/jquery.inputmask.js')}}"></script>
<script src="{{asset('assets/vendor/masking/bindings/inputmask.binding.js')}}"></script>

<!-- Calendar.IO -->
<script src='{{asset('assets/js/fullcalendar/main.js')}}'></script>

<!-- Main script -->
<script src="{{asset('assets/js/main.js')}}"></script>


