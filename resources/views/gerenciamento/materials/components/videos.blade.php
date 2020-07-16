<div class="panel panel-{{Auth::user()->css}}">
    <!-- START DEFAULT DATATABLE -->
   <div class="panel panel-default">
       <div class="panel-heading">
           <h3 class="panel-title">Videos</h3>
           <ul class="panel-controls">
               <li><a href="{{route('GetVideosCreate')}}" class="panel-"><span class="glyphicon glyphicon-plus"></span></a></li>
               <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
           </ul>
       </div>
       <div class="panel-body">
           <table class="table datatable">
               <thead>
                   <tr>
                       <th>Nome</th>
                       <th>Categoria</th>
                       <th>Ilha</th>
                       <th>Setor</th>
                       <th>Ações</th>
                   </tr>
               </thead>
               <tbody>
               @foreach ($videos as $video)
                   <form id="video{{$video->id}}">
                   @csrf
                   <tr id="trvideo{{$video->id}}">
                       <td>
                           <input type="text" class="form-control" name="name" id="nameVid{{$video->id}}" value="{{$video->name}}" required>
                       </td>
                       <td>
                        <select name="sub_local_id" id="sub_local_idVid{{$video->id}}" class="form-control" onfocus="getSubName({{$video->sub_local_id}},{{$video->id}},'video')" required>
                            <optgroup label="Opção Atual">
                                <option value="{{$video->sub_local_id}}">{{ $video->subLocal->name }}</option>
                            </optgroup>
                            <optgroup label="Opções">
                            @foreach ($subs as $sub)
                                <option value="{{$sub->id}}">{{$sub->name}}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </td>
                       <td>
                           <select name="ilha_id" id="ilha_idVid{{$video->id}}" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$video->ilha_id}}">{{ $video->ilha->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                               @foreach ($ilhas as $ilha)
                                   <option value="{{$ilha->id}}">{{$ilha->name}}</option>
                               @endforeach
                               </optgroup>
                           </select>
                       </td>
                       <td>
                           <select name="setor_id" id="setor_idVid{{$video->id}}" onfocus="getSetorName({{$video->sector}},{{$video->id}},'video')" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$video->sector}}">{{ $video->setor->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                                   @foreach ($setores as $setor)
                                       <option value="{{$setor->id}}">{{$setor->name}}</option>
                                   @endforeach
                               </optgroup>
                           </select>
                           <input type="hidden" name="change" value="0" id="changeVid{{$video->id}}">
                       </td>
                       <td>
                           <a href="javascript:notyConfirm({{$video->id}},'video')"><span class="label label-info label-form">Editar</span></a>
                           <a href="javascript:notyDelete({{$video->id}},'video')"> <span class="label label-danger label-form">Excluir</span></a>
                       </td>
                   </tr>
                   </form>
               @endforeach
               </tbody>
           </table>


       </div>
   </div>
</div>
