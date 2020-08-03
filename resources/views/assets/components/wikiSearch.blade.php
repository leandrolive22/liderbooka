<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form">

            <div class="form-group">
                {{-- <div class="col-md-8">
                    <h3>Categorias</h3>
                    <div class="btn-group btn-group-justified">
                        <a href="#" class="btn btn-primary active">Videos</a>
                        <a href="{{ route('CircularesWiki', Auth::user()->ilha_id) }}"
                            class="btn btn-primary">PPT</a>
                        <a href="{{ route('GetRoteirosIndex', ['ilha' => Auth::user()->ilha_id ]) }}"
                            class="btn btn-primary">Pdf</a>
                        <a href="#" class="btn btn-primary">Xls</a>

                    </div>
                    <br>
                </div>
                <br>
                <div class="col-md-8">
                    <h3>Etiquetas</h3>
                    <div class="btn-group btn-group-justified">
                        <a href="#" class="btn btn-primary active">Recentes</a>
                        <a  href="{{ route('GetLidosIndex', Auth::user()->ilha_id) }}" class="btn btn-primary">Lidos</a>
                        <a href="#" class="btn btn-primary">Não lidos</a>
                        <a href="#" class="btn btn-primary">Alterados</a>
                    </div>

                </div> --}}
                <div class="list-group border-bottom push-down-20" style="padding:1rem;">
                    <a href="{{  route('GetRoteirosIndex', ['ilha' => Auth::user()->ilha_id ]) }}"
                        class="list-group-item py-1">Roteiros <span id="RoteirosBtn"
                            class="badge badge-danger"></span></a>
                    <a href="{{ route('CircularesWiki', [ 'ilha' => Auth::user()->ilha_id ]) }}"
                        class="list-group-item py-1">Circulares <span id="CircularesBtn"
                            class="badge badge-danger"></span></a>
                     <a  href="{{ route('GetMateriaisIndex', [ 'ilha' => Auth::user()->ilha_id ]) }}"
                        class="list-group-item py-1">Materiais <span id="MateriaisBtn"
                           class="badge badge-danger"></span></a>
                     <a href="{{ route('GetVideosIndex', [ 'ilha' => Auth::user()->ilha_id ]) }}"
                          class="list-group-item py-1">Videos <span id="VideosBtn"
                             class="badge badge-danger"></span></a>
                </div>
        </form>
    </div>
</div>
</div>

@section('wikiCount')
<script type="text/javascript">
    $(document).ready(function(){
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
          if (data.length == 1){
              $(".timeline").remove()
          }
          console.log.data
        });
    });
</script>
@endsection
