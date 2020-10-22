<div class="panel panel-default">
    <div class="panel-body">
            <div class="form-group">
                @if(in_array(44,Session::get('permissionsIds')) && isset($ilhas) && !is_null($ilhas))
                <div class="col-md-6">
                    <div class="row">
                        <h3>Selecione uma ilha e clique nos links normalmente</h3>
                        <div class="form-group col-md-12">
                            <select class="form-control select" name="ilhas" id="ilhas" onchange="ilhaSelected(this.value)">
                                @forelse($ilhas as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                <option disabled="true">Nenhum dado encontrado</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <h3>Etiquetas</h3>
                        <div class="btn-group btn-group-justified">
                            <a href="#" class="btn btn-primary active">Recentes</a>
                            <a  href="{{ route('GetLidosIndex', Auth::user()->ilha_id) }}" class="btn btn-primary">Lidos</a>
                            <a href="#" class="btn btn-primary">Não lidos</a>
                            <a href="#" class="btn btn-primary">Alterados</a>
                        </div>

                    </div> --}}
                </div>
               
                @endif
                <div class="list-group border-bottom push-down-20 @if(in_array(44,Session::get('permissionsIds')) && isset($ilhas) && !is_null($ilhas)) col-md-6 @endif" style="padding:1rem;">
                    <a href="{{  route('GetRoteirosIndex', ['ilha' => Auth::user()->ilha_id ]) }}"
                        class="list-group-item selectIlha py-1 @if($titlePage == 'Roteiros') active @endif ">Roteiros <span id="RoteirosBtn"
                        class="badge badge-danger"></span></a>
                    <a href="{{ route('CircularesWiki', [ 'ilha' => Auth::user()->ilha_id ]) }}"
                        class="list-group-item selectIlha py-1 @if($titlePage == 'Circulares') active @endif ">Comunicados <span id="CircularesBtn"
                        class="badge badge-danger"></span></a>
                    <a  href="{{ route('GetMateriaisIndex', [ 'ilha' => Auth::user()->ilha_id ]) }}"
                        class="list-group-item selectIlha py-1 @if($titlePage == 'Materiais') active @endif ">Materiais <span id="MateriaisBtn"
                        class="badge badge-danger"></span></a>
                    <a href="{{ route('GetVideosIndex', [ 'ilha' => Auth::user()->ilha_id ]) }}"
                      class="list-group-item selectIlha py-1 @if($titlePage == 'Videos') active @endif ">Videos <span id="VideosBtn"
                      class="badge badge-danger"></span></a>
                </div>
          </div>
      </div>
</div>

@section('wikiCount')
<script type="text/javascript">
function ilhaSelected(val) {
    $.each($('a.selectIlha'), function(i,v) {
        hr = $(v).attr('href')
        newHr = hr.replace("/{{Auth::user()->ilha_id}}",'/'+val)
        $(v).attr('href',newHr)
    });
}
$(document).ready(function(){
    try {
        $.getJSON('{{ route("GetCountCirculares",["ilha" => Auth::user()->ilha_id,"cargo" => Auth::user()->cargo_id]) }}',function(data){
            $("#CircularesBtn").html(data)
        });

        $.getJSON('{{ route("GetCountRoteiros",["ilha" => Auth::user()->ilha_id,"cargo" => Auth::user()->cargo_id]) }}',function(data){
            $("#RoteirosBtn").html(data)
        });

        $.getJSON('{{ route("GetCountMateriais",["ilha" => Auth::user()->ilha_id,"cargo" => Auth::user()->cargo_id]) }}',function(data){
            $("#MateriaisBtn").html(data)
        });

        $.getJSON('{{ route("GetCountVideos",["ilha" => Auth::user()->ilha_id,"cargo" => Auth::user()->cargo_id]) }}',function(data){
          $("#VideosBtn").html(data)
      });
    } catch (e) {
        console.log(e)
    } 
});
</script>
@endsection
