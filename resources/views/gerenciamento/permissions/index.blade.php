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
			@include('assets.components.preloaderdefault')
			<div id="content" style="display: none;">
				<!-- START CONTENT FRAME TOP -->
				<div class="content-frame-top">
					<div class="page-title">
						<a href="{{ url()->previous() }}">
							<h2>
								<span class="fa fa-arrow-circle-o-left"></span> 
								Permissões
							</h2>
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
					{{-- Usuários e Ações básicas --}}
					<div class="panel panel-default" >
						<div class="panel-heading">
							<h3 class="panel-title">
								Selecione um Usuário
							</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								@if($id === 0)
								<select class="form-control select" name="users" data-live-search="true" id="users" onchange="carregarPermissoesDeUsuario(this)">
									<option value="0">Selecione um usuário para alterar as permissões</option>
									@forelse ($users as $item)
									<option value="{{$item->id}}">{{$item->name}}</option>
									@empty
									<option value="0">Nenhum usuário encontrado</option>
									@endforelse
								</select>
								@else
								<label class="check">
									<input type="radio" readonly="true" checked="true" name="users" id="users" value="{{$users->id}}" class="iradio"> {{$users->name}}
								</label>
								@endif
							</div>
						</div>
					</div>
					{{-- ./Usuários e Ações básicas --}}
					{{-- Permissões --}}
					<div class="panel panel-colorful">
						<div class="panel-heading">
							<h3 class="panel-title">
								Permissões
							</h3>
						</div>
						<div class="panel-body">
							<table class="table datatable" id="permissionTable">
								<thead>
									<tr>
										<th>
											<span class="fa fa-check"></span>
										</th>
										<th>
											Permissão
										</th>
									</tr>
								</thead>
								<tbody>
									@forelse($allPermissions as $item)
									<tr>
										<td>
											<label class="switch">
												<input type="checkbox" class="permissions" @if($id === 0) disabled="true" @elseif(in_array($item->id,$userPermissions)) checked="true" @endif name="permissions" value="{{$item->id}}"/>
												<span></span>
											</label>
										</td>
										<td>
											{{$item->name}}
										</td>
									</tr>
									@empty
									<tr>
										<td colspan="2">Nenhum dado encontrado</td>
									</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<div class="panel-footer">
							<div class="pull-right">

								<button class="btn btn-default" type="button" onclick="sync(@if($id > 0) {{$id}} @endif)" @if($id === 0) disabled="true" @endif id="syncBtn">
									<div id="loadedBtn">
										<span id="sync" class="fa fa-cloud-upload">&nbsp;</span>
										Sincronizar
									</div>
									<div id="loadedGif" class="text-center" style="display: none">
										<img src="{{asset('img/loaders/default.gif')}}" alt="loadedGif">
									</div>
								</button>
							</div>
						</div>
					</div>
					{{-- ./Permissões --}}
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
	function preloaderPage(event) {
		if(event == 'on' || event == true) {
			event = 1
		}

		if(event === 1) {
			$("#loadedGif").show()
			$("#loadedBtn").hide()
		} else {
			$("#loadedBtn").show()
			$("#loadedGif").hide()
		}
	}

	function sync(id) {
		preloaderPage(1)
		data = 'user='+id+'&permissions='+getPermissions()
		if(typeof $("input.permissions:checked").val() !== 'undefined' || $("input.permissions:checked").val() !== null) {
			$.ajax({
				url: '{{ route("PostPermissionsStore") }}',
				data: data,
				method: 'POST',
				success: function(data) {
					console.log(data)
					noty({
						text: data.msg,
						type: 'success',
						layout: 'topRight',
						timeout: 3000
					});
					preloaderPage(2)
				},
				error: function(xhr) {
					console.log(xhr)
					noty({
						text: 'Erro, tente novamente',
						type: 'error',
						layout: 'topRight',
						timeout: 3000
					});
					preloaderPage(2)
				}
			});
		} else {

		}
	}

	function getPermissions() {
		values = ''
		$.each($(".permissions:checked"),function(i,v){
			if(typeof $(v).val() !== 'undefined') {
				values += v.value+','
				console.log(v.value)
			}
		})
		len = values.length
		if(len === 0) {
			return ''
		}
		return values.substr(0,(len-1))
	}

	function carregarPermissoesDeUsuario(element) {
		$("#permissionTable").hide()
		user = element.value;
		if(user > 0) {
			preloaderPage(1)
			$('#syncBtn').attr('onclick','sync('+user+')')
			$.ajax({
				url: "{{ route('GetPermissionsByUser') }}",
				data: 'user='+user,
				success: function(data) {
					$(".permissions").attr('disabled',false)
					$(".permissions").attr('checked',false)
					// verifica resultados
					if(data.length > 0) {
						for(i=0; i<data.length; i++) {
							id = data[i]
					          //Marca permissões do usuário
					          $.each($("input.permissions"),function(i,v){
					          	if(v.value == id) {
					          		$(v).prop('checked',true)
					          	}
					          });
					      }
					      preloaderPage(2)
					  } else {
					  	preloaderPage(2)
					  }

					  $("#syncBtn").prop('disabled',false)
					  $("#permissionTable").show()
					  noty({
					  	text: 'Altere as Permissões do usuário',
					  	layout: 'topRight',
					  	type: 'info'
					  });
					}, 
					error: function(xhr) {
						console.log(xhr)
						noty({
							text: 'Erro, tente novamente',
							type: 'error',
							layout: 'topRight',
							timeout: 3000
						});

						$("input.permissions").prop('checked',false)
						$("#permissionTable").show()
					}
				});
		}
		$("#permissionTable").show()
	}

	$(() => {
		$("#preloaderDefault").hide().remove()
		$("#content").show()
		
	})
</script>
@endsection