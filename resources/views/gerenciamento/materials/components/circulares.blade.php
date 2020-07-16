<div class="panel panel-{{Auth::user()->css}}">
    <!-- START DEFAULT DATATABLE -->
   <div class="panel panel-default">
       <div class="panel-heading">
           <h3 class="panel-title">Circulares</h3>
           <ul class="panel-controls">
               <li><a href="{{route('GetCircularesCreate')}}" class="panel-"><span class="glyphicon glyphicon-plus"></span></a></li>
               <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
           </ul>
       </div>
       <div class="panel-body">
           <table class="table datatable">
               <thead>
                   <tr>
                       <th>Nome</th>
                       <th>Numero</th>
                       <th>Ano</th>
                       <th>Segmento</th>
                       <th>Ilha</th>
                       <th>Setor</th>
                       <th>Status</th>
                       <th>Ações</th>
                   </tr>
               </thead>
               <tbody>
               @foreach ($circulares as $circular)
                   <form id="circular{{$circular->id}}">
                   @csrf
                   <tr id="trCircular{{$circular->id}}">
                       <td>
                           <input type="text" class="form-control" name="name" id="nameCirc{{$circular->id}}" value="{{$circular->name}}" required>
                       </td>
                       <td>
                           <input type="number" class="form-control" value="{{ $circular->number }}" name="number" id="numberCirc{{$circular->id}}" required>
                       </td>
                       <td>
                           <input type="number" class="form-control" value="{{ $circular->year }}" name="year" id="yearCirc{{$circular->id}}" maxlength="4" required>
                       </td>
                       <td>
                           <select name="segment" id="segmentCirc{{$circular->id}}" class="form-control" onfocus="getSubName({{$circular->segment}},{{$circular->id}},'material')" required>
                            <optgroup label="Opção Atual">
                                <option value="{{$circular->segment}}">{{ $circular->subLocal['name'] }}</option>
                            </optgroup>
                            <optgroup label="Opções">
                            @foreach ($subs as $sub)
                                <option value="{{$sub->id}}">{{$sub->name}}</option>
                            @endforeach
                            </optgroup>
                        </select>
                       </td>
                       <td>
                           <select name="ilha_id" id="ilha_idCirc{{$circular->id}}" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$circular->ilha_id}}">{{ $circular->ilha->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                               @foreach ($ilhas as $ilha)
                                   <option value="{{$ilha->id}}">{{$ilha->name}}</option>
                               @endforeach
                               </optgroup>
                           </select>
                       </td>
                       <td>
                           <select name="setor_id" id="setor_idCirc{{$circular->id}}" onfocus="getSetorName({{$circular->setor_id}},{{$circular->id}},'Circular')" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$circular->setor_id}}" id="CirculargetSetorName{{$circular->id}}">{{ $circular->setor->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                                   @foreach ($setores as $setor)
                                       <option value="{{$setor->id}}">{{$setor->name}}</option>
                                   @endforeach
                               </optgroup>
                           </select>
                       </td>
                       <td>
                           <select name="status" id="statusCirc{{$circular->id}}" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$circular->status}}">{{$circular->status}}</option>
                               </optgroup>
                               <optgroup label="Opções">
                                       <option value="Vigente">Vigente</option>
                                       <option value="Revisada">Revisada</option>
                               </optgroup>
                           </select>
                           <input type="hidden" name="change" value="0" id="changeCirc{{$circular->id}}">
                       </td>
                       <td>
                           <a href="javascript:notyConfirm({{$circular->id}},'circular')"><span class="label label-info label-form">Editar</span></a>
                           <a href="javascript:notyDelete({{$circular->id}},'circular')"> <span class="label label-danger label-form">Excluir</span></a>
                       </td>
                   </tr>
                   </form>
               @endforeach
               </tbody>
           </table>

       </div>
   </div>
</div>
