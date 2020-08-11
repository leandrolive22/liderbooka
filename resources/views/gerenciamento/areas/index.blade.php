@php 
	$col = 0;
	if(isset($carteiras)) {
		$col += 4;
	}
	if(isset($setores)) {
		$col += 4;
	}
	if(isset($ilhas)) {
		$col += 4;
	}
@endphp

@extends('layouts.app', ["current"=>"adm"])
@section('style')
<style type="text/css">
	
</style>
@endsection
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">


	<!-- PAGE CONTENT -->
	<div class="page-content">

		@component('assets.components.x-navbar')
		@endcomponent

		<!-- START CONTENT FRAME -->
		<div class="content-frame">

			<!-- START CONTENT FRAME TOP -->
			<div class="content-frame-top">
				<div class="page-title">
					<h2>
						<a href="{{ url()->previous() }}">
							<span class="fa fa-arrow-circle-o-left"></span> 
						</a>
						Áreas
					</h2>
				</div>
				<div class="pull-right">
					<button class="btn btn-default content-frame-right-toggle">
						<span class="fa fa-bars"></span>
					</button>
				</div>
				<!-- END CONTENT FRAME TOP -->

			</div>
			<!-- END CONTENT FRAME TOP-->

			<!-- START CONTENT FRAME LEFT -->
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="row">
					<div class="panel panel-default">
						<div class="col-lg-{{$col}} col-md-{{$col}} col-sm-{{$col}}">
							<div class="panel-heading">
								<div class="panel-title">
									Carteiras
								</div>
							</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>
												ID
											</th>
											<th>
												Nome
											</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($carteiras))
											@component()
											@endcomponent
										@endif
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-{{$col}} col-md-{{$col}} col-sm-{{$col}}">
							<div class="panel-heading">
								<div class="panel-title">
									Carteiras
								</div>
							</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>
												ID
											</th>
											<th>
												Nome
											</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($carteiras))
											@component()
											@endcomponent
										@endif
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-{{$col}} col-md-{{$col}} col-sm-{{$col}}">
							<div class="panel-heading">
								<div class="panel-title">
									Carteiras
								</div>
							</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>
												ID
											</th>
											<th>
												Nome
											</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($carteiras))
											@component()
											@endcomponent
										@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END CONTENT FRAME LEFT -->
		</div>
		<!-- START CONTENT FRAME -->
		
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
@endsection
@section('Javascript')
<script type="text/javascript">
	
</script>
@endsection