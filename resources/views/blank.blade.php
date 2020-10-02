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
					<a href="{{ url()->previous() }}">
						<h2><span class="fa fa-arrow-circle-o-left"></span> Clique aqui para voltar</h2>
					</a>
				</div>
				<div class="pull-right">
					<button class="btn btn-default content-frame-right-toggle">
						<span class="fa fa-bars"></span>
					</button>
				</div>
				<!-- END CONTENT FRAME TOP -->

			</div>
			<!-- END CONTENT FRAME TOP-->

			<!-- START CONTENT FRAME RIGHT -->
			@include('assets.components.updates')
			<!-- END CONTENT FRAME RIGHT -->

			<!-- START CONTENT FRAME LEFT -->
			<div class="content-frame-body content-frame-body-left">
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