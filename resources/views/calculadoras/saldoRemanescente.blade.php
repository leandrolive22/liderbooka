<!DOCTYPE html>
<html lang="br">
    <head>
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Calculadora</title>
        <link type="text/css" rel="shortcut icon" href="{{asset('objetos/imagens/favicon.ico')}}" type="image/x-icon">
        <link type="text/css" href="{{asset('objetos/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link  type="text/css"  href="{{asset('objetos/plugins/awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <link type="text/css"  href="{{asset('objetos/plugins/notification/bs4.pop.css')}}" rel="stylesheet">
        <link type="text/css"  href="{{asset('objetos/style.css')}}" rel="stylesheet">
    </head>
    <script type="text/javascript" src="{{asset('objetos/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('objetos/plugins/popper/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('objetos/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('objetos/plugins/notification/bs4.pop.js')}}"></script>
    <script type="text/javascript" src="{{asset('objetos/plugins/priceformat/jquery.price_format.min.js')}}"></script>
    <script src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('objetos/funcoes.js')}}"></script>
    <body>
        <div class="page-container">
            <form onsubmit="return false">
                <div class="card">
                <br>
                    <div class="card-body">
                    <div class="input-group-text bg-secondary text-light" style="font-size: 1rem; text-align:center;">
                        <b>Base de consulta - Saldo Remanescente</b>
                    </div>
                    <br>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-secondary text-light">N Contrato</span></div>
                            <input type="number" class="form-control" id="number" name="number">
                            <button onclick="search()" class="btn btn-xs btn-default"><span id="btnSearch" class="fa fa-search"></span></button>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-secondary text-light">Escritório</span></div>
                            <input type="text" class="form-control" id="office" name="office" readonly>
                            <button onclick="copyText('office')" class="btn btn-xs btn-default"><span id="span_office" class="fa fa-copy"></span></button>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-secondary text-light">Telefone 1</span></div>
                            <input type="text" class="form-control" id="phone1" name="phone1" readonly>
                            <button onclick="copyText('phone1')" class="btn btn-xs btn-default"><span id="span_phone1" class="fa fa-copy"></span></button>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-secondary text-light">Telefone 2</span></div>
                            <input type="text" class="form-control" id="phone2" name="phone2" readonly>
                            <button onclick="copyText('phone2')" class="btn btn-xs btn-default"><span id="span_phone2" class="fa fa-copy"></span></button>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-secondary text-light">Endereço</span></div>
                            <input type="text" class="form-control" id="address" name="address" readonly>
                            <button onclick="copyText('address')" class="btn btn-xs btn-default"><span id="span_address" class="fa fa-copy"></span></button>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-secondary text-light">Cidade</span></div>
                            <input type="text" class="form-control" id="city" name="city" readonly>
                            <button onclick="copyText('city')" class="btn btn-xs btn-default"><span id="span_city" class="fa fa-copy"></span></button>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-secondary text-light">UF</span></div>
                            <input type="text" class="form-control" id="uf" name="uf" readonly>
                            <button onclick="copyText('uf')" class="btn btn-xs btn-default"><span id="span_uf" class="fa fa-copy"></span></button>
                        </div>
                        <div class="input-group col-md-12">
                        <button class="btn btn-light text-danger" style="margin-left:70%" data-toggle="modal" data-target="#analitico">Analítico</button>
                        </div>
                    </div>
                    <div class="rodape">powered by <img src="{{asset('objetos/imagens/logo.png')}}"> Liderança - Desenvolvimento</div>
                </div>
            </form>
        </div>  
        <!-- Modal -->
        <div class="modal fade" id="analitico" tabindex="-1" role="dialog" aria-labelledby="analiticoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="analiticoLabel">Analítico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-responsive datatable">
                            <thead>
                                <tr>
                                    <td>
                                        Nº Contrato Origem
                                    </td>
                                    <td>
                                        Escritório
                                    </td>
                                    <td>
                                        Telefone 1
                                    </td>
                                    <td>
                                        Telefone 2
                                    </td>
                                    <td>
                                        Endereço
                                    </td>
                                    <td>
                                        Cidade
                                    </td>
                                    <td>
                                        UF
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($select as $item)
                                    <tr>
                                        <td>{{$item->Nr_Contrato_Origem}}</td>
                                        <td>{{$item->Escritorio}}</td>
                                        <td>{{$item->Tel_Escritorio_1}}</td>
                                        <td>{{$item->Tel_Escritorio_2}}</td>
                                        <td>{{$item->Endereco_Escritorio}}</td>
                                        <td>{{$item->Cidade_Escritorio}}</td>
                                        <td>{{$item->UF_Escritorio}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Nenhum dado disponível</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $select->links() }}
                    </div>
                </div>
            </div>
        </div>
        <script lang="javascript">
            function search() {
                $("span#btnSearch").attr('class','fa fa-spinner fa-spin')
                contrato = $("#number").val()

                if(contrato !== "" || contrato !== 0) {    
                    data = 'contrato='+contrato+'&user={{Auth::id()}}&ilha={{Auth::user()->id}}'

                    $.ajax({
                        url: '{{route("GetCalculadorasBaseConsultaContrato")}}',
                        method: 'POST',
                        data: data,
                        success: (response) => {
                            console.log(response)
                            $("#office").val(response[0].Escritorio)
                            $("#phone1").val(response[0].Tel_Escritorio_1)
                            $("#phone2").val(response[0].Tel_Escritorio_2)
                            $("#address").val(response[0].Endereco_Escritorio)
                            $("#city").val(response[0].Cidade_Escritorio)
                            $("#uf").val(response[0].UF_Escritorio)
                        },
                        error: (xhr) => {
                            console.log(xhr)
                            $("#office").val("Não encontrado")
                            $("#phone1").val("Não encontrado")
                            $("#phone2").val("Não encontrado")
                            $("#address").val("Não encontrado")
                            $("#city").val("Não encontrado")
                            $("#uf").val("Não encontrado")
                        }
                    });
                }

                return $("#btnSearch").attr('class','fa fa-search')
            }

            function copyText(id) {
                //captura o elemento input
                let inputTest = $("#"+id)
                
                //seleciona todo o texto do elemento
                inputTest.select();
                //executa o comando copy
                //aqui é feito o ato de copiar para a area de trabalho com base na seleção
                document.execCommand('copy');
                $("#span_"+id).attr('class','fa fa-check')
                setTimeout(() => {$("#span_"+id).attr('class','fa fa-copy')}, 2000);
            };

        </script>
    </body>
</html>
                                                        