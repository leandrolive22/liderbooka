@extends('layouts.app', ["current"=>"wiki"])
@section('Javascript')
       <!-- START THIS PAGE PLUGINS-->     
<script type='text/javascript' src="{{ asset('js/faq.js') }}"></script>   
<script type='text/javascript' src="{{ asset('js/plugins/icheck/icheck.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/plugins/highlight/jquery.highlight-4.js') }}"></script>
       <!-- END THIS PAGE PLUGINS-->   
@endsection
@section('content')


<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

        <br>
        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="{{asset('/')}}">Home</a></li>
            <li><a href="{{('/home')}}">Faq</a></li>


        </ul>
            <!-- END BREADCRUMB -->
            
            <!-- PAGE TITLE -->
            <div class="page-title">                    
            <h3 href="{{('/home')}}"><span class="fa fa-arrow-circle-o-left"></span> FAQ</h3>
            </div> 
            <!-- END PAGE TITLE -->                
            
            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">
                
                <div class="row">
                    <div class="col-md-8">
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3 class="push-down-0">Gerenciamento de Contas</h3>
                            </div>
                            <div class="panel-body faq">
                                
                                <div class="faq-item" >
                                    <div class="faq-title"><span class="fa fa-angle-down"></span>Como Mudar de senha ?</div>
                                    <div class="faq-text">
                                        <h5>Mudança de senha</h5>
                                        <p>Para mudar de senha vá até a aba de perfil la tera um campo para alteração de senha, para realizar a atualização basta inserir a senha nova campo.</p>
                                        <p>Caso não consiga por favor contatar via E-Mail na aba suporte.</p>
                                    </div>
                                </div>
                                
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span>Como alterar estilo do lider book ?</div>
                                    <div class="faq-text">
                                        <h5>Estilo do LiderBook</h5>
                                        <p>Para Alterar o estilo do seu Lider book Basta ir até a aba de perfil e escolher um estilo que o agrade e pode alterar quantas vezes forem necessarias. </p>
                                        <p>Caso não consiga por favor contatar via E-Mail na aba suporte.</p>
                                    </div>
                                </div>
                                
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span>O que fazer quando esquecer a senha ?</div>
                                    <div class="faq-text">
                                        <h5>Como Recuperar sua senha </h5>
                                        <p>Caso esqueça sua senha recomendamos contatar seu superior.</p>
                                        <p>Caso não consiga por favor contatar via E-Mail na aba suporte.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3 class="push-down-0">Chat</h3>
                            </div>
                            <div class="panel-body faq">
                                
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span>Como falar com seu supervisor via chat ?</div>
                                    <div class="faq-text">
                                        <h5>Falando com o supervisor via chat</h5>
                                        <p>Para falar com seu supervisor via chat basta ir até a aba ChatBook, clicar no perfil do seu supervisor ou em algum grupo que ele tenha criado.</p>
                                        <p>Caso não consiga por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                </div>
                                
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span>Conteúdo ChatBook</div>
                                    <div class="faq-text">
                                        <h5>Informações Sobre o ChatBook</h5>
                                        <p>No canto superior direito do ChatBook tem os seus contatos, no canto inferior direito os grupos que voce foi incluso, no canto esquerda as suas conversas.</p>
                                        <p>Caso tenha algum erro por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                </div>
                                
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span>Segurança ChatBook</div>
                                    <div class="faq-text">
                                        <h5>Monitoramento</h5>
                                        <p>Todas as conversas do ChatBook são rigorosamente monitoradas, no uso indevido pode ocorrer consequencias.</p>
                                        <p>Caso tenha alguma duvida por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3 class="push-down-0">Home page</h3>
                            </div>
                            <div class="panel-body faq">
                                
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span> Home Page Conteúdo</div>
                                    <div class="faq-text">
                                        <h5>Informações Sobre o Home page</h5>
                                        <p>No canto superior direito do Home page tem as carinhas de humor dos colaboradores, e no canto superior esquerdo tem a timeline com as postagens ordenadas pela data e prioridade.</p>
                                        <p>Caso tenha algum erro por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span> Home Page Postagens</div>
                                    <div class="faq-text">
                                        <h5>Informações Sobre as postagens e reações</h5>
                                        <p>Todas as reações das postagens como curtidas e descurtidas, são brevemente visiveis para os gestores com informações precisas como nome de quem curtiu ou descurtiu. </p>
                                        <p>Caso tenha algum erro por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3 class="push-down-0">Wiki</h3>
                            </div>
                            <div class="panel-body faq">
                                
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span> Wiki Conteúdo</div>
                                    <div class="faq-text">
                                        <h5>Informações Sobre o Wiki</h5>
                                        <p>Wiki é aonde tem todos os materiais que os operadores precisam, como roteiros, circulares, materiais, calculadoras e videos, basta clicar em um dos cards que será direcionado para a informação correspondente a ele.</p>
                                        <p>Caso tenha algum erro por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span> Wiki tabelas</div>
                                    <div class="faq-text">
                                        <h5>Informações como utilizar a tabela</h5>
                                        <p>Para realizar uma busca basta colocar uma parte do Conteúdo do material que a filtragem será instantanea podendo filtrar tambem pela data ou numero.  </p>
                                        <p>Caso tenha algum erro por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-title"><span class="fa fa-angle-down"></span> Wiki Assinatura digital</div>
                                    <div class="faq-text">
                                        <h5>Assinatura Digital</h5>
                                        <p>Assinatura Digital é feita com criptografia de ponta com extrema segurança.  </p>
                                        <p>Caso tenha algum erro por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                    <div class="faq-text">
                                        <h5>Assinatura Funcionamento</h5>
                                        <p>Assinatura Digital quando voce assina uma vez gera uma criptografia unica para cada material e é salva.  </p>
                                        <p>Caso tenha algum erro por favor contatar via E-Mail na aba Suporte.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>                        
                    <div class="col-md-3">
                        
                        <div class="panel panel-secondary">
                            <div class="panel-body">
                                    <div class="pull-right">
                                        <button class="btn btn-default" id="faqOpenAll"><span class="fa fa-angle-down"></span> Abrir todas as guias</button>
                                        <button class="btn btn-default" id="faqCloseAll"><span class="fa fa-angle-up"></span> Fechar todas as guias</button>
                                    </div>                                       
                                </div>                                    
                            </div>
                        </div>          
                    </div>
                </div>
                                                        
            </div>
            <!-- END PAGE CONTENT WRAPPER -->                       
                            
        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->
                           
@endsection

                                                    