<script lang="javascript">
    $("#{{$id ?? 'btnExport'}}").click(() => {
        $("#formExportBasicDataTableExcel").submit()
        noty({
            text: 'Seu download será feito em instantes, aguarde...',
            layout: 'topRight',
            type: 'success',
            timeout: 3000
        });
    }); // end function
</script>

@section('basicDatatableExcel')
<form action="{{ route('PostApiExportBasicDatatable', [
        'id' => Auth::id(),
        'ilha' => Auth::user()->ilha_id,
    ]) }}" method="post" style="display:none" id="formExportBasicDataTableExcel">
@csrf
<input type="hidden" name="data" id="data" value="{{str_replace('\u0000*\u0000', '',( json_encode( Session::get('excelExportsData', []) ) ) )}}">
</form>
@endsection
