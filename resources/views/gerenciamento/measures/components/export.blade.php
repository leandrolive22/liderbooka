@extends('layouts.app', ["current"=>"adm"])
@section('css')
    <style>
        td {
            padding:2px;
        }
        hr {
            border: 1px solid grey; 
            width: 80%; 
            margin-right: 20%; 
        }
    </style>
@endsection
@section('content')

<!-- START PAGE CONTAINER -->
<div class="panel panel-default">
    <div class="panel-body" style="width: 70%; margin-left:15%;">
        <a id="btnBack" href="{{asset('measures/manager')}}" class="btn btn-dark" style="position: fixed; left: 1%;">Voltar</a>
        <br>
        <div class="row col-md-12">
            <table class="table-bordered" id="exportPdf">
                <tbody>
                    {{-- Cabeçalho --}}
                    <tr>
                        <td colspan="2">
                            <img class="profile-image" src="{{asset('img/favicon.png')}}" alt="Logo empresa">
                        </td>
                        <td colspan="2">
                            <h3>
                                AVISO DE ADVERTÊNCIA
                            </h3>
                        </td>
                        <td colspan="2">
                            <h3>
                                Versão 03
                                01/03/2019
                            </h3>
                        </td>
                    </tr>
                    {{-- Dados do Colaborador --}}
                    <tr>
                        <td colspan="3">
                            <h5>Nome do Empregado:</h5>
                            {{-- Verificação  --}}
                            @if(!is_null($show->user->name))
                                <p>{{$show->user->name}}</p>
                            @else
                                <p>N/A</p>
                            @endif
                        </td>
                        <td colspan="3">
                            <h5>Registro:</h5>
                            {{-- Verificação  --}}
                            @if(!is_null($show->user->matricula))
                                <p>{{$show->user->matricula}}</p>
                            @else
                                <p>N/A</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <h5>Nome do Solicitante:</h5>
                            {{-- Verificação  --}}
                            @if(!is_null($show->creator->name))
                                <p>{{$show->creator->name}}</p>
                            @else
                                <p>N/A</p>
                            @endif
                        </td>
                        <td colspan="3">
                            <h5>Data da Solicitação:</h5>
                            <p>{{date('d/m/Y',strtotime($show->created_at))}}</p>
                        </td>
                    </tr>
                    {{-- Notificação da Medida --}}
                    <tr style="text-align: justify;">
                        <td colspan="6">
                            <h5>Notificação da Medida:</h5>
                            @php
                                echo '<p>'.nl2br($show->description).'</p>';
                            @endphp
                            <p>{{$show->obs}}</p>
                            <h5>Embasamento legal:</h5>
                            <p>É Importante esclarecer que, irregularidades autoriza a recisão do contrado de trabalho por justa causa, razão pela qual esperamos que V.Sa. procure evitar a reincidência em procedimento análogos, para que não tenhamos no futuro, seguirmos com as enérgicas medidas que nos são facultadas por lei.</p>
                            {{-- Assinatura --}}
                            <p>Ciente do empregado ou Representante Legal (quando menor)</p>
                        </td>
                    </tr>
                    {{-- Assinatura --}}
                    <tr>
                        <td colspan="3">
                            Empregador
                            <hr/>
                        </td>
                        <td colspan="3">
                            Empregado
                            <p>
                                {{-- Verificação  --}}
                                @if(!is_null($show->aceite_hash))
                                    Assinatura digital: <b>{{$show->aceite_hash}}</b> em <b>{{date('d/m/Y - H:i',strtotime($show->created_at))}}</b>
                                @else
                                    <b>N/A</b>
                                @endif
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            1ª Testemnha
                            <hr/>
                        </td>
                        <td colspan="3">
                            2ª Testemunha
                            <hr/>
                        </td>
                    </tr>
                    {{-- Elaboração --}}
                    <tr>
                        <td colspan="3">
                            <h5>Elaboração</h5>
                            {{-- Verificação  --}}
                            @if(!is_null($show->creator->name))
                                <p>{{$show->creator->name}}</p>
                            @else
                                <p>N/A</p>
                            @endif
                        </td>
                        <td colspan="3">
                            <h5>Setor</h5>
                            {{-- Verificação  --}}
                            @if(!is_null($show->setor))
                                <p>{{$show->setor}}</p>
                            @else
                                <p>N/A</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row col-md-12">
                <button class="btn btn-block btn-danger" id="btnExport" onclick="table2pdf()">
                    Exportar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Javascript')
    <script lang="javascript">
        function table2pdf() {
            $("#btnExport").attr('style','display:none')
            $("#btnBack").attr('style','display:none')
            
            window.print()
            setTimeout(() => {
                $("#btnExport").attr('style','display:block')
                $("#btnBack").attr('style','display:none')
            },500)
        }
    </script>
@endsection