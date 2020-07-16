@extends('layouts.app', ["current"=>"wiki"])
@section('css')
<style>
  @import "compass/css3";
  
  /* Font */
  
  @import url(http://weloveiconfonts.com/api/?family=entypo);
  
  
  [class*="entypo-"]:before {
    font-family: 'entypo', sans-serif;
  }
  
  #cashicon {
    font-family: arial;
    font-weight: bold;
    font-size: 22px;
    padding-left: 19px;
    padding-right: 5px;
  } 
  
  /* Universal Settings*/
  
  $primary: #5e5e5e;
  $secondary: #ccc;
  $tertiary: #858585;
  $quaternary: #fff;
  $quinary: #fff;
  $inactive: #fff;
  $background: #1e1e1e;
  $hover: #292929;
  
  * {
    user-select: none;
    cursor: default;
  }
  
  body {
    background: #0a0a0a;
    margin: 0;
    margin-bottom: 20px;
  }
  
  p {margin: 0;}
  a {display: block; cursor: pointer;}
  .icon {padding-left: 15px; cursor: pointer;}
  
  hr {
    height: 0;
    border: 0;
    margin: 0;
    border-top: 1px solid black; 
    border-bottom: 1px solid #383838;
  }
  
  .hrv {
    height: 70px;
    margin-bottom: -10px;
    margin-left: 20px;
    margin-right: 20px;
    border-left: 1px solid;
    display: inline-block;
  }
  
  
  
  
  
  /* Local */
  
  hr                { margin-bottom: 4%; }
  .tr1              { transition: 0.15s; }
  .ptrend           { color: #356b3d; }
  .ptrend:hover     { color: green; }
  .ntrend           { color: #8f4747; }
  .ntrend:hover     { color: #a82b2b; }
  .dtrend           { color: $primary; }
  .dtrend:hover     { color: $tertiary; }
  .figure           { float: right; }
  
  .w_item {
    display: block;
    margin-bottom: 8px;
  }
  
  .span22 {
    width: 22%;
    height: 90%;
    margin: 1%;
    float: left;
    display: inline;
  }
  
  .span50 {
    background-color: #171717;
    width: 50%;
    height: 90%;
    margin: 1%;
    float: left;
    display: inline;
  }
  
  .well {
    font: 20px Calibri Light, sans-serif;
    background: #1e1e1e;
    width: 92%;
    padding: 4%;
    margin-bottom: 4%;
    transition: 0.5s;
  }
  
  .well:hover {
    background: #212121;
  }
  
  .title {
    font: 23px Calibri Light, sans-serif;
    color: $primary;
  }
  
  .title2 {
    font: 20px Calibri Light, sans-serif;
    font-weight: bold;
    color: $primary;
    margin-bottom: 4%;
  }
  
  .title2:hover {
    color: $tertiary;
  }
  
  
  
  
  
  /* Other */
  
  .container {
    height: 100%;
    width: 100%;
    min-width: 1100px;
  }
  
  .w1 {
    height: auto;
  }
  
  .w1:hover {
    .w1d { color: $tertiary; }
  }
  
  .w2:hover {
    .w2d { color: $tertiary; }
  }
  
  .w2_1:hover {
    .w2_1d { color: $tertiary; }
  }
  
  .w2_2:hover {
    .w2_2d { color: $tertiary; }
  }
  
  .w3:hover {
    .w3d { color: $tertiary; }
  }
  
  .w3_1:hover {
    .w3_1d { color: $tertiary; }
  }
  
  *, :after, :before {
    box-sizing: border-box;
  }
  
  :focus {
    outline: none;
  }
  
  button {
    overflow: visible;
    border: 0;
    padding: 0;
    margin: 1.8rem;
  }
  .btn.striped-shadow span {
    display: block;
    position: relative;
    z-index: 2;
    border: 5px solid;
  }
  .btn.striped-shadow.white span {
    border-color: #fff;
    color: #fff;
    background: #77bfa1;
  }
  
  .btn.striped-shadow.blue span {
    border-color: #4183D7;
    background: #77bfa1;
    color: #4183D7;
  }
  .btn.striped-shadow.dark span {
    border-color: #393939;
    background: #77bfa1;
    color: #393939;
  }
  
  
  
  button.btn.striped-shadow.white:after, button.btn.striped-shadow.white:before {
    background-image: linear-gradient(
      135deg,
      transparent 0,
      transparent 5px,
      #fff 5px,
      #fff 10px,
      transparent 10px
    );
  }
  
  button.btn.striped-shadow.blue:after, button.btn.striped-shadow.blue:before {
    background-image: linear-gradient(
      135deg,
      transparent 0,
      transparent 5px,
      #4183D7 5px,
      #4183D7 10px,
      transparent 10px
    );
  }
  
  button.btn.striped-shadow.dark:after, button.btn.striped-shadow.dark:before {
    background-image: linear-gradient(
      135deg,
      transparent 0,
      transparent 5px,
      #393939 5px,
      #393939 10px,
      transparent 10px
    );
  }
  
  button.btn.striped-shadow:hover:before {
    max-height: calc(100% - 10px);
  }
  
  button.btn.striped-shadow:after {
    width: calc(100% - 4px);
    height: 8px;
    left: -10px;
    bottom: -9px;
    background-size: 15px 8px;
    background-repeat: repeat-x;
  }
  button.btn.striped-shadow:after, button.btn.striped-shadow:before {
    content: '';
    display: block;
    position: absolute;
    z-index: 1;
    transition: max-height .3s, width .3s, -webkit-transform .3s;
    transition: transform .3s, max-height .3s, width .3s;
    transition: transform .3s, max-height .3s, width .3s, -webkit-transform .3s;
  }
  
  .btn.striped-shadow:hover {
    -webkit-transform: translate(-12px, 12px);
    -ms-transform: translate(-12px, 12px);
    transform: translate(-12px, 12px);
    z-index: 3;
  }
  
  button.btn.striped-shadow:hover:after, button.btn.striped-shadow:hover:before {
    -webkit-transform: translate(12px, -12px);
    -ms-transform: translate(12px, -12px);
    transform: translate(12px, -12px);
  }
  button.btn.striped-shadow:before {
    width: 8px;
    max-height: calc(100% - 5px);
    height: 100%;
    left: -12px;
    bottom: -5px;
    background-size: 8px 15px;
    background-repeat: repeat-y;
    background-position: 0 100%;
  }
  
  body {
    color:#020203;
    font-size:1em;
    background-color:#222;
  }
  
  .description {
    color:#aaa;
    font-size:0.8em;
  }
  
  a:visited, a:active, a {
    color:#aaa;
    text-decoration:underline;
  }
  
  a:hover {
    color:#FFF;
    text-decoration:underline;
  }
  
  .btn {
    -webkit-border-radius: 3;
    -moz-border-radius: 3;
    border:0;
    border-radius: 3px;
    color: #ffffff;
    font-size: 15px;
    background: #4462c6;
    padding: 10px 20px 10px 20px;
    text-decoration: none;
  }
  
  .btn:hover {
    background: #3d5296;
    text-decoration: none;
  }
  
  .amcharts-map-image:hover {
    filter: url(#blur);
  }
  #h3name{
    text-align:center;
    padding-left:520px;
    font-family:Arial;
  }
  
  </style>
@endsection
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- START PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

      <br>
      <!-- START BREADCRUMB -->
      <ul class="breadcrumb">
          <li><a href="{{asset('/')}}">Reports</a></li>
      </ul>
      <!-- END BREADCRUMB -->

      <!-- PAGE TITLE -->
      <div class="page-title">
          <a href="{{url()->previous()}}"><h3><span class="fa fa-arrow-circle-o-left"></span> Relatorios Avançados</h3>  </a>
      </div>
      <!-- END PAGE TITLE -->

        <!-- START PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
          <div class="row">
            <div class="panel-body">
              <!-- START DEFAULT DATATABLE -->
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h2 id="h3name" class="panel-title" style="color:black;"><strong> Usuários  Que Vizualizaram </strong></h2>
                  </div>
                <div class="panel-body" style="max-height: 500px; overflow-y: auto">
                    <table id="exportTable" class="table table-dark">
                        <thead>
                            <tr>
                                <th  style="color:black;">Nome</th>
                                <th  style="color:black;">Data</th>
                                <th  style="color:black;">Cargo</th>
                                <th  style="color:black;">Supervisor</th>
                                <th  style="color:black;">Gerente</th>
                                <th  style="color:black;">Superintendente</th>
                                <th  style="color:black;">Ilha</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <td>{{$material->name}}</td>
                                <td style="color:white;">{{$material->created_at}}</td>
                                <td>{{$material->cargo}} </td>
                                <td>@if(is_null($material->supervisor)) N/A  @else {{$material->supervisor}} @endif </td>
                                <td>@if(is_null($material->gerente)) N/A  @else {{$material->gerente}} @endif </td>
                                <td>@if(is_null($material->superintendente)) N/A  @else {{$material->superintendente}} @endif </td>
                                <td>{{$material->ilha}} </td>
                              </tr>
                        @endforeach
                            </tbody>
                        </table>
                        <button style="position:relative; left:500px; top:-35px;" class="btn striped-shadow dark"><span id="exportBtn">Exportar</span></button>
                    </div>
                </div>
               <!-- END DEFAULT DATATABLE -->
            </div>
          </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- START PAGE CONTAINER -->
@endsection

@section('assinatura')
@include('assets.js.assinatura-Js')
@endsection

@section('Javascript')
  <script type="text/javascript" src="{{ asset('js/plugins/tableexport/tableExport.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/plugins/tableexport/jquery.base64.js') }}"></script>
  @component('assets.components.basicDatatable',['id' => 'exportBtn', 'span' => 'exportSpan'])
  @endcomponent
@endsection