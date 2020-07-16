<div class="panel panel-{{Auth::user()->css}}">
    <!-- START DEFAULT DATATABLE -->
   <div class="panel panel-default">
       <div class="panel-heading">
           <h3 class="panel-title">Materiais</h3>
           <ul class="panel-controls">
               <li><a href="{{route('GetMateriaisCreate')}}" class="panel-"><span class="glyphicon glyphicon-plus"></span></a></li>
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
               @foreach ($materiais as $material)
                   <form id="material{{$material->id}}">
                   @csrf
                   <tr id="trmaterial{{$material->id}}">
                       <td>
                           <input type="text" class="form-control" name="name" id="nameMat{{$material->id}}" value="{{$material->name}}" required>
                           
                       </td>
                       <td>
                        <select name="sub_local_id" id="sub_local_idMat{{$material->id}}" class="form-control" onfocus="getSubName({{$material->sub_local_id}},{{$material->id}},'material')" required>
                            <optgroup label="Opção Atual">
                                <option value="{{$material->sub_local_id}}">{{ $material->subLocal->name }}</option>
                            </optgroup>
                            <optgroup label="Opções">
                            @foreach ($subs as $sub)
                                <option value="{{$sub->id}}">{{$sub->name}}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </td>
                       <td>
                           <select name="ilha_id" id="ilha_idMat{{$material->id}}" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$material->ilha_id}}">{{ $material->ilha->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                               @foreach ($ilhas as $ilha)
                                   <option value="{{$ilha->id}}">{{$ilha->name}}</option>
                               @endforeach
                               </optgroup>
                           </select>
                       </td>
                       <td>
                           <select name="setor_id" id="setor_idMat{{$material->id}}" onfocus="getSetorName({{$material->sector}},{{$material->id}},'material')" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$material->sector}}">{{ $material->setor->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                                   @foreach ($setores as $setor)
                                       <option value="{{$setor->id}}">{{$setor->name}}</option>
                                   @endforeach
                               </optgroup>
                           </select>
                           <input type="hidden" name="change" value="0" id="changeMat{{$material->id}}">
                       </td>
                       <td>
                           <a href="javascript:notyConfirm({{$material->id}},'material')"><span class="label label-info label-form">Editar</span></a>
                           <a href="javascript:notyDelete({{$material->id}},'material')"> <span class="label label-danger label-form">Excluir</span></a>
                       </td>
                   </tr>
                   </form>
               @endforeach
               </tbody>
           </table>

       </div>
   </div>
</div>
