<style>
    /* Linhas visualizados e não visualizadas*/
    .trRed {
        border-left: solid;
        border-size: 5px;
        border-color: red;
    }
    .trGreen {
        border-left: solid;
        border-size: 5px;
        border-color: green;
    }
    /* Logo da Empresa*/
    #logoMenu {
        width: 65%;
    }

    @media screen and (max-width: 600px) {
        #logoMenu {
            width: 125px;
        }
    }

    @if(!in_array(Request::url(),[asset('manager/measures/manager'),asset('monitoring/manager'),route('PostRelatoriosAnalytics'),route('GetMonitoriasMediaSegments')]))
    /* personalizar a barra em geral, aqui estou definindo 4px de largura para a barra vertical */
    ::-webkit-scrollbar {
        width: 4px;
    }

    /* aqui é para personalizar o fundo da barra, neste caso estou colocando um fundo cinza escuro*/
    ::-webkit-scrollbar-track {
        background: #110133;
    }

    /* aqui é a alça da barra, que demonstra a altura que você está na página
    estou colocando uma cor azul clara nela*/
    /* degrade para a barra vertical */
    ::-webkit-scrollbar-thumb {
        background: #110133;
        background: -moz-linear-gradient(top, #300f63 0%, #5a29a6 25%, #00f6fa 50%, #5a29a6 76%, #300f63 100%);
        background: -webkit-linear-gradient(top, #300f63 0%, #5a29a6 25%, #00f6fa 50%, #5a29a6 76%, #300f63 100%);
        background: linear-gradient(to bottom, #300f63 0%, #5a29a6 25%, #00f6fa 50%, #5a29a6 76%, #300f63 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#2a2530', endColorstr='#2a2530', GradientType=0);
    }
    @endif

</style>
