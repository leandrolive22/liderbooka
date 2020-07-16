<div class="modal in" id="modalTermo" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="defModalHead">Termo de Conduta</h4>
				<button type="button" class="pull-right btn btn-outline-default" onclick="$('#modalTermo').hide()" data-dismiss="modal"><span class="fa fa-times"></span></button>
			</div>
			<div class="modal-body" style="overflow-y: scroll; min-height: 400px;">
				<embed src="{{ asset('storage/manager/codigodeConduta.pdf') }}" type="application/pdf" style="width: 100%; min-height: 390px">
			</div>
		</div>
	</div>
</div>
