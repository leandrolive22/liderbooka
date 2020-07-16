<div class="panel panel-{{Auth::user()->css}}">
    <!-- START DEFAULT DATATABLE -->
   <div class="panel panel-default">
       <div class="panel-heading">
           <h3 class="panel-title">Calculadoras</h3>
           <ul class="panel-controls">
               <li><a href="{{route('GetCalculadorasCreate')}}" class="panel-"><span class="glyphicon glyphicon-plus"></span></a></li>
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
               @foreach ($calculadoras as $calculadora)
                   <form id="calculadora{{$calculadora->id}}">
                   @csrf
                   <tr id="trcalculadora{{$calculadora->id}}">
                       <td>
                           <input type="text" class="form-control" name="name" id="nameCalc{{$calculadora->id}}" value="{{$calculadora->name}}" required>
                       </td>
                       <td>
                        <select name="sub_local_id" id="sub_local_idCalc{{$calculadora->id}}" class="form-control" required>
                            <optgroup label="Opção Atual">
                            <option value="{{$calculadora->sub_local_id}}" >{{ $calculadora->subLocal['name'] }}</option>
                            </optgroup>
                            <optgroup label="Opções">
                            @foreach ($subs as $sub)
                                <option value="{{$sub->id}}">{{$sub->name}}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </td>
                       <td>
                           <select name="ilha_id" id="ilha_idCalc{{$calculadora->id}}" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$calculadora->ilha_id}}">{{ $calculadora->ilha->name }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                               @foreach ($ilhas as $ilha)
                                   <option value="{{$ilha->id}}">{{$ilha->name}}</option>
                               @endforeach
                               </optgroup>
                           </select>
                       </td>
                       <td>
                           <select name="setor_id" id="setor_idCalc{{$calculadora->id}}" class="form-control" required>
                               <optgroup label="Opção Atual">
                                   <option value="{{$calculadora->setor_id}}">{{ $calculadora->setor['name'] }}</option>
                               </optgroup>
                               <optgroup label="Opções">
                                   @foreach ($setores as $setor)
                                       <option value="{{$setor->id}}">{{$setor->name}}</option>
                                   @endforeach
                               </optgroup>
                           </select>
                           <input type="hidden" name="change" value="0" id="changeCalc{{$calculadora->id}}">
                       </td>
                       <td>
                           <a href="javascript:notyConfirm({{$calculadora->id}},'calculator')"><span class="label label-info label-form">Editar</span></a>
                           <a href="javascript:notyDelete({{$calculadora->id}},'calculator')"> <span class="label label-danger label-form">Excluir</span></a>
                       </td>
                   </tr>
                   </form>
               @endforeach
               </tbody>
           </table>

       </div>
   </div>
</div>
