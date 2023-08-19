	<script src="{{ asset('b/plugins/jQuery/jquery-3.4.1.min.js')}} "></script>
	<script src="{{ asset('b/dist/js/popper.min.js')}} "></script>
	<script src="{{ asset('b/plugins/bootstrap/js/bootstrap.min.js')}} "></script>
	<script src="{{ asset('b/plugins/metisMenu/metisMenu.min.js') }}"></script>
	<script src="{{ asset('b/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
	{{-- <script src="{{ asset('b/plugins/chartJs/Chart.min.js') }}"></script> --}}
	<script src="{{ asset('b/plugins/sparkline/sparkline.min.js') }}"></script>
	<script src="{{ asset('b/plugins/datatables/dataTables.min.js') }}"></script>
	<script src="{{ asset('b/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
	{{-- <script src="{{ asset('b/dist/js/pages/dashboard.js') }}"></script> --}}
	<script src="{{ asset('b/dist/js/sidebar.js') }}"></script>
	<script src="{{ asset('b/alert/script.js') }}"></script>
	<script src="{{ asset('b/plugins/rh-select2/select2.min.js') }}"></script>
	<script src="{{ asset('b/plugins/flatpicker/flatpickr.min.js') }}"></script>
	<link href="{{ asset('b/alert/style.css') }}" rel="stylesheet" type="text/css">
	<script src="{{ asset('b/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('b/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('b/datatables.net/js/buttons.colVis.min.js') }}"></script>
	<script src="{{ asset('b/datatables.net/js/buttons.bootstrap.min.js') }}"></script>
	<script src="{{ asset('b/datatbl_js_files/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('b/datatbl_js_files/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('b/datatbl_js_files/buttons.flash.min.js') }}"></script>
	<script src="{{ asset('b/datatbl_js_files/jszip.min.js') }}"></script>
	<script src="{{ asset('b/datatbl_js_files/vfs_fonts.js') }}"></script>
	<script src="{{ asset('b/datatbl_js_files/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('b/datatbl_js_files/buttons.print.min.js') }}"></script>
	<script src="{{ asset('b/plugins/elevatezoom/jquery.ez-plus.js') }}"></script>
	<script src="{{ asset('b/plugins/jquery.sumoselect/jquery.sumoselect.min.js') }}"></script>
	 <!-- Third Party Scripts(used by this page)-->
	 <script src="{{ asset('b/plugins/summernote/summernote.min.js') }}"></script>
	 <script src="{{ asset('b/plugins/summernote/summernote-bs4.min.js') }}"></script>
	 <!--Page Active Scripts(used by this page)-->
	 <script src="{{ asset('b/plugins/summernote/summernote.active.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('.flatpickr').flatpickr({
				enableTime: true,
				dateFormat: "m-d-Y",
			});
		});
		$('.select-one').SumoSelect({
			search: true
		});
		$('.basic-multiple').select2();
</script>
</body>
</html>