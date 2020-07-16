<div class="panel panel-{{Auth::user()->css}}">
    <!-- START DEFAULT DATATABLE -->
   <div class="panel panel-default">
       <div class="panel-heading">
           <h3 class="panel-title">Roteiros</h3>
           <ul class="panel-controls">
               <li><a href="{{route('GetRoteirosCreate')}}" class="panel-"><span class="glyphicon glyphicon-plus"></span></a></li>
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
               @foreach ($roteiros as $roteiro)
                   <form id="roteiro{{$roteiro->id}}">
                   @csrf
                   <tr id="trroteiro{{$roteiro->id}}">
                       <td>
                           <input type="text" class="form-control" name="name" id="nameScript{{$roteiro->id}}" value="{{$roteiro->name}}" required>
                       </td>
                       <td>
                        <select name="sub_local_id" id="sub_local_idScript{{$roteiro->id}}" class="form-control" onfocus="getSubName({{$roteiro->sub_local_id}},{{$roteiro->id}},'Roteiro')" required>
                            <optgroup label="Opção Atual">
                                <option value="{{$roteiro->sub_local_id}}">{{ $roteiro->subLocal->name }}</option>
                            </optgroup>
                            <optgroup label="Opções">
                            @foreach ($subs as $sub)
                                <option value="{{$sub->id}}">{{$sub->name}}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </td>
                       <td>
                           <select name="ilha_id" id="ilha_idScript{{$roteiro->id}}" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$roteiro->ilha_id}}">{{ $roteiro->ilha->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                               @foreach ($ilhas as $ilha)
                                   <option value="{{$ilha->id}}">{{$ilha->name}}</option>
                               @endforeach
                               </optgroup>
                           </select>
                       </td>
                       <td>
                           <select name="setor_id" id="setor_idScript{{$roteiro->id}}" onfocus="getSetorName({{$roteiro->sector}},{{$roteiro->id}},'Roteiro')" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$roteiro->sector}}">{{ $roteiro->setor->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                                   @foreach ($setores as $setor)
                                       <option value="{{$setor->id}}">{{$setor->name}}</option>
                                   @endforeach
                               </optgroup>
                           </select>
                           <input type="hidden" name="change" value="0" id="changescript{{$roteiro->id}}">
                       </td>
                       <td>
                           <a href="javascript:notyConfirm({{$roteiro->id}},'script')"><span class="label label-info label-form">Editar</span></a>
                           <a href="javascript:notyDelete({{$roteiro->id}},'script')"> <span class="label label-danger label-form">Excluir</span></a>
                       </td>
                   </tr>
                   </form>
               @endforeach
               </tbody>
           </table>

       </div>
   </div>
</div>
