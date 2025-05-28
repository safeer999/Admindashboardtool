
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from seantheme.com/color-admin/admin/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 11:31:33 GMT -->
<head>


	<meta charset="utf-8" />
	<title>Color Admin | Dashboard V1</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	


	<!-- ================== BEGIN core-css ==================
	 -->
	<link href="{{asset('admin6css/vendor.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin6css/default/app.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin6css/custom.css')}}" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	

	<!-- ================== BEGIN page-css ================== -->
	<link href="{{asset('admin6plugins/jvectormap-next/jquery-jvectormap.css')}}" rel="stylesheet" />
	<link href="{{asset('admin6plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
	<link href="{{asset('admin6plugins/gritter/css/jquery.gritter.css')}}" rel="stylesheet" />
	<!-- ================== END page-css ================== -->
	
	<!-- ================== END core-css ================== -->
	
	<!-- ================== BEGIN page-css ================== -->
		<link href="{{asset('admin2/assets/css/vendor.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin2/assets/css/default/app.min.css')}}" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	
	<!-- ================== BEGIN page-css ================== -->
	<link href="{{asset('admin2/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin2/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" />

</head>
<body>
	 
	<div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div> -->
	

	<!-- BEGIN #app -->
	<div id="app" class="app app-header-fixed app-sidebar-fixed ">

		<!-- BEGIN #header -->
	@include('layouts.components.top_header')
		<!-- END #header -->
	
		<!-- BEGIN #sidebar -->
	@include('layouts.components.sidebar')
		<!-- END #sidebar -->
		
		<!-- BEGIN #content -->
		<div id="content" class="app-content">
    	@yield('content')
		</div>

		<!-- END #content -->
	
		<!-- BEGIN theme-panel -->
		{{--<div class="theme-panel">
			<a href="javascript:;" data-toggle="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
			<div class="theme-panel-content" data-scrollbar="true" data-height="100%">
				<h5>App Settings</h5>
				
				<!-- BEGIN theme-list -->
				<div class="theme-list">
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-red" data-theme-class="theme-red" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Red">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-pink" data-theme-class="theme-pink" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Pink">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-orange" data-theme-class="theme-orange" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Orange">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-yellow" data-theme-class="theme-yellow" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Yellow">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-lime" data-theme-class="theme-lime" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Lime">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-green" data-theme-class="theme-green" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Green">&nbsp;</a></div>
					<div class="theme-list-item active"><a href="javascript:;" class="theme-list-link bg-teal" data-theme-class="" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Default">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-cyan" data-theme-class="theme-cyan" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Cyan">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-blue" data-theme-class="theme-blue" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Blue">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-purple" data-theme-class="theme-purple" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Purple">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-indigo" data-theme-class="theme-indigo" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Indigo">&nbsp;</a></div>
					<div class="theme-list-item"><a href="javascript:;" class="theme-list-link bg-black" data-theme-class="theme-gray-600" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Black">&nbsp;</a></div>
				</div>
				<!-- END theme-list -->
				
				<div class="theme-panel-divider"></div>
				
				<div class="row mt-10px">
					<div class="col-8 control-label text-body fw-bold">
						<div>Dark Mode <span class="badge bg-primary ms-1 py-2px position-relative" style="top: -1px;">NEW</span></div>
						<div class="lh-14">
							<small class="text-body opacity-50">
								Adjust the appearance to reduce glare and give your eyes a break.
							</small>
						</div>
					</div>
					<div class="col-4 d-flex">
						<div class="form-check form-switch ms-auto mb-0">
							<input type="checkbox" class="form-check-input" name="app-theme-dark-mode" id="appThemeDarkMode" value="1" />
							<label class="form-check-label" for="appThemeDarkMode">&nbsp;</label>
						</div>
					</div>
				</div>
				
				<div class="theme-panel-divider"></div>
				
				<!-- BEGIN theme-switch -->
				<div class="row mt-10px align-items-center">
					<div class="col-8 control-label text-body fw-bold">Header Fixed</div>
					<div class="col-4 d-flex">
						<div class="form-check form-switch ms-auto mb-0">
							<input type="checkbox" class="form-check-input" name="app-header-fixed" id="appHeaderFixed" value="1" checked />
							<label class="form-check-label" for="appHeaderFixed">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="row mt-10px align-items-center">
					<div class="col-8 control-label text-body fw-bold">Header Inverse</div>
					<div class="col-4 d-flex">
						<div class="form-check form-switch ms-auto mb-0">
							<input type="checkbox" class="form-check-input" name="app-header-inverse" id="appHeaderInverse" value="1" />
							<label class="form-check-label" for="appHeaderInverse">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="row mt-10px align-items-center">
					<div class="col-8 control-label text-body fw-bold">Sidebar Fixed</div>
					<div class="col-4 d-flex">
						<div class="form-check form-switch ms-auto mb-0">
							<input type="checkbox" class="form-check-input" name="app-sidebar-fixed" id="appSidebarFixed" value="1" checked />
							<label class="form-check-label" for="appSidebarFixed">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="row mt-10px align-items-center">
					<div class="col-8 control-label text-body fw-bold">Sidebar Grid</div>
					<div class="col-4 d-flex">
						<div class="form-check form-switch ms-auto mb-0">
							<input type="checkbox" class="form-check-input" name="app-sidebar-grid" id="appSidebarGrid" value="1" />
							<label class="form-check-label" for="appSidebarGrid">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="row mt-10px align-items-center">
					<div class="col-8 control-label text-body fw-bold">Gradient Enabled</div>
					<div class="col-4 d-flex">
						<div class="form-check form-switch ms-auto mb-0">
							<input type="checkbox" class="form-check-input" name="app-gradient-enabled" id="appGradientEnabled" value="1" />
							<label class="form-check-label" for="appGradientEnabled">&nbsp;</label>
						</div>
					</div>
				</div>
				<!-- END theme-switch -->
				
				<div class="theme-panel-divider"></div>
				
				<h5>Admin Design (6)</h5>
				<!-- BEGIN theme-version -->
				<div class="theme-version">
					<div class="theme-version-item">
						<a href="index-2.html" class="theme-version-link active">
							<span style="background-image: url(../assets/img/theme/default.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/transparent/" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/transparent.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/apple/" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/apple.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/material/" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/material.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/facebook/" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/facebook.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/google/" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/google.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
				</div>
				<!-- END theme-version -->
				
				<div class="theme-panel-divider"></div>
				
				<h5>Language Version (9)</h5>
				<!-- BEGIN theme-version -->
				<div class="theme-version">
					<div class="theme-version-item">
						<a href="index-2.html" class="theme-version-link active">
							<span style="background-image: url(../assets/img/version/html.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/ajax/" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/ajax.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/angularjs/" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/angular1x.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/angularjs19/" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/angular10x.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/svelte/" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/svelte.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="javascript:alert('Laravel Version only available in downloaded version.');" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/laravel.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="javascript:alert('Django Version only available in downloaded version.');" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/django.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/vue3/" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/vuejs.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/react/" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/reactjs.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="javascript:alert('.NET Core MVC Version only available in downloaded version.');" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/dotnet.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/admin/nextjs/" class="theme-version-link">
							<span style="background-image: url(../assets/img/version/nextjs.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
				</div>
				<!-- END theme-version -->
				
				<div class="theme-panel-divider"></div>
				
				<h5>Frontend Design (5)</h5>
				<!-- BEGIN theme-version -->
				<div class="theme-version">
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/frontend/one-page-parallax/" target="_blank" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/one-page-parallax.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/frontend/e-commerce/" target="_blank" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/e-commerce.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/frontend/blog/" target="_blank" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/blog.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/frontend/forum/" target="_blank" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/forum.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
					<div class="theme-version-item">
						<a href="https://seantheme.com/color-admin/frontend/corporate/" target="_blank" class="theme-version-link">
							<span style="background-image: url(../assets/img/theme/corporate.jpg);" class="theme-version-cover"></span>
						</a>
					</div>
				</div>
				<!-- END theme-version -->
				
				<div class="theme-panel-divider"></div>
				
				<a href="https://seantheme.com/color-admin/documentation/" class="btn btn-dark d-block w-100 rounded-pill mb-10px" target="_blank"><b>Documentation</b></a>
				<a href="javascript:;" class="btn btn-default d-block w-100 rounded-pill" data-toggle="reset-local-storage"><b>Reset Local Storage</b></a>
			</div>
		</div>--}}
		<!-- END theme-panel -->
		<!-- BEGIN scroll-top-btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-theme btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->
	
	<!-- ================== BEGIN core-js ================== -->
	<script>
    $(document).ready(function () {
        $('#cnic').inputmask('99999-9999999-9'); // CNIC format
    });
</script>
	<script src="{{asset('admin2/assets/plugins/datatables.net/js/dataTables.min.js')}}" type="0120a43a662143d45adf1f99-text/javascript"></script>
	<script src="{{asset('admin2/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}" type="0120a43a662143d45adf1f99-text/javascript"></script>
	<script src="{{asset('admin2/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}" type="0120a43a662143d45adf1f99-text/javascript"></script>
	<script src="{{asset('admin2/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}" type="0120a43a662143d45adf1f99-text/javascript"></script>
	<script src="{{asset('admin2/assets/js/demo/table-manage-default.demo.js')}}" type="0120a43a662143d45adf1f99-text/javascript"></script>
	<script src="{{asset('admin2/assets/plugins/%40highlightjs/cdn-assets/highlight.min.js')}}" type="0120a43a662143d45adf1f99-text/javascript"></script>
	<script src="{{asset('admin2/assets/js/demo/render.highlight.js')}}" type="0120a43a662143d45adf1f99-text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>

	<script src="{{asset('admin6js/vendor.min.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6js/app.min.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	  <script src="{{ asset('path/to/your/jquery.min.js') }}"></script>
    <script src="{{ asset('path/to/your/bootstrap.bundle.min.js') }}"></script>
	 @stack('scripts')
	<!-- ================== END core-js ================== -->
	
	<!-- ================== BEGIN page-js ================== -->
	<script src="{{asset('admin6plugins/gritter/js/jquery.gritter.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.canvaswrapper.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.colorhelpers.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.saturated.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.browser.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.drawSeries.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.uiConstants.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.time.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.resize.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.pie.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.crosshair.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.categories.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.navigate.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.touchNavigate.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.hover.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.touch.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.selection.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.symbol.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/flot/source/jquery.flot.legend.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/jquery-sparkline/jquery.sparkline.min.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/jvectormap-next/jquery-jvectormap.min.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/jvectormap-content/world-mill.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script src="{{asset('admin6plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	
	<script src="{{asset('admin6js/demo/dashboard.js')}}" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<!-- ================== END page-js ================== -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-Y3Q0VGQKY3" type="9e3175db7c46b0a00cc73ccd-text/javascript"></script>
	<script type="9e3175db7c46b0a00cc73ccd-text/javascript">
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
	
		gtag('config', 'G-Y3Q0VGQKY3');
	
	</script>
<!-- Add before closing </body> -->
<!-- Include CSS -->


<!-- Include JS -->




	<script src="{{asset('cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="9e3175db7c46b0a00cc73ccd-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"9423439d9fd0a41c","version":"2025.4.0-1-g37f21b1","r":1,"serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"4db8c6ef997743fda032d4f73cfeff63","b":1}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from seantheme.com/color-admin/admin/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 11:31:42 GMT -->
</html>






























