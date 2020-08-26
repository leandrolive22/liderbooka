@extends('layouts.app', ['current' => 'home'])
@section('content')
<div  class="page-sidebar mCustomScrollbar _mCS_1 mCS-autoHide page-sidebar-fixed scroll">
  <!-- START X-NAVIGATION -->
  <ul  class="x-navigation" >
    <li  class="xn-logo">
      <a href="{{ asset('/home') }}" style='width:100%;  text-align:center; padding:0%;'>
        @if(Auth::user()->css == 'white')
        <img src='{{ asset('img/logo-lcinza.png') }}' alt='Logo Branco - Liderança' id="logoMenu">
        @else
        <img src='{{ asset('img/logo-topo21-white_pqno.png') }}' alt='Logo Preto - Liderança' id="logoMenu">
        @endif
      </a>
    </li>
    <li class="xn-profile">
      <a class="profile-mini" href="{{ asset('profile/'.base64_encode(Auth::user()->id) ) }}">
        <img src="{{ asset('img/bookLogo.png') }}" alt="{{ Auth::user()->username }}"/>
      </a>
      <div class="profile">
        <div class="profile-image">
          <img src="{{ asset('img/bookLogo.png') }}" alt=""/>
        </div>
        <div class="profile-data">
          <div class="profile-data-name">{{ Auth::user()->name }}</div>
          <div class="profile-data-title" id="cargoScript"></div>
        </div>

      </div>
    </li>
    <li>
      <a href="#">
        <span class="fa fa-times"></span>
        <span >Menu Desativado</span>
      </a>
    </li>
  </ul>
</div>
<div class="page-container">

  <!-- PAGE CONTENT -->
  <div class="page-content">
   <!-- START CONTENT FRAME -->
   <div class="content-frame">
    <div class="x-navigation x-navigation-horizontal x-navigation-panel">
      <h1 class="text-white text-center   ">
        {{ explode(' ',Auth::user()->name)[0] }}, Seja bem vindo ao LiderBook!
      </h1>
    </div>
    <div class="content-frame-top">
      <div class="panel panel-colorful" role="document">
        <div class="modal-content">
          <div class="panel-header"><h2 style="font-style: bold">Política de Privacidade</h2></div>
          <div class="panel-body">
            <p>A confidencialidade dos dados pessoais dos utilizadores deste sistema é importante para o LiderBook e os
            dados recolhidos serão usados para tornar seu uso o mais seguro possível.</p>
            <p>Todas as informações pessoais relativas a usuários/clientes do sistema serão protegidas por
              senhas, criptografia e tratadas em concordância com a Lei da Proteção de Dados Pessoais de 26 de outubro de
            1998 (Lei n.º 67/98).</p>
            <p>Os dados pessoais recolhidos poderão incluir nomes, e-mails, telefones, endereços e outros campos necessário
            para a gestão e utilização do sistema.</p>
            <p>O uso deste sistema pressupõe a <b>aceitação deste Acordo de Privacidade</b>
              e reservamos o direito de altera-lo sem aviso prévio. Deste modo, recomendamos que consulte periódicamente
            nossa política de privacidade.</p>

            <h2>Segurança da Informação</h2>
            <p>Os dados aqui tratados não poderão ser extraviados, copiados ou movidos para outros sistemas sem a autorização
              dos administradores deste sistema. Toda movimentação efetuada no sistema será registrada com data, hora, usuário e ip
            do computador.</p>

            <h2>Os Cookies</h2>
            <p>Utilizaremos cookies para armazenar informações, tais como as suas preferências pessoais quando utilizar
            o sistema.</p>
            <p>Você detém o poder de desligar os seus cookies, nas opções do seu browser, ou efetuando alterações nas
              ferramentas de programas Anti-Virus. No entanto, isso poderá alterar a forma como interage com o sistema.
              Isso poderá afetar ou não permitir que faça logins em programas, sites ou fóruns da nossa e de
            outras redes.</p>

            <p>Atenção, armazenaremos seus dados e histórico de utilização neste aplicativo.</p>

            <p>Para continuar você precisa aceitar esta condição confirmando o seu conhecimento nas regras de utilização dos dados.</p>

            <p>Declaro ainda que não acessarei o sistema para uso pessoal e nem fora do horário de expediente, sendo eu o único responsavel por estes acessos.</p>

          </div>
          <div class="panel-footer">
            <div class="col-md-12 pull-right btn-group">
              <form action="{{ route('PostUsersLgpd') }}" method="POST">
                @csrf
                <button class="btn btn-success pull-right">Concordar</button>
              </form>
              <form action="{{ route('logout') }}" method="POST">
                <button type="submit" class="btn btn-danger pull-right">Sair</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
