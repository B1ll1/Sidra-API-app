<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                <form action="{{route('import')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-1">
                                <div class="col-md-5">
                                    <input id="choose-file" type="file" name="import_file[]" multiple class="filestyle form-control" data-input="false" data-buttonText="Escolher Arquivos"/>
                                    <button class="btn btn-primary ">Importar Arquivos</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                </form>

                </div>
            </div>
        </div>
    </body>
</html>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

<!-- <script type="text/javascript">

        var prodUF;
        var qtdProdUF;
        var anoPAM;
        var tabelaSidra = 1613;
        var classificacaoLavouraSidra = 82;
        //permanente 1613,82
        //temporaria 1612,81
        $(document).ready(inicializa());

        function inicializa() {
            prodUF = new Array();
            qtdProdUF = 0;

            var prodAnt = 0;
            var linha;

            //
            // Efetua a leitura da quantidade produzida dos produtos da lavoura e as UFs produtoras
            //
            //var apiURL = "http://www.sidra.ibge.gov.br/api/values/h/n/t/" + tabelaSidra + "/c" + classificacaoLavouraSidra + "/allxt/n3/all/p/last/v/214";
            var apiURL = "https://crossorigin.me/http://www.sidra.ibge.gov.br/api/values/h/n/t/" + tabelaSidra + "/c" + classificacaoLavouraSidra + "/allxt/n3/all/p/1992/v/allxp";
            //ROTA PRA PEGAR TODAS AS CIDADES DE UMA UF
            //https://crossorigin.me/http://www.sidra.ibge.gov.br/api/values/h/n/t/1612/n6/in%20n3%2012/p/last/v/214/c81/all
            //http://codebeautify.org/json-to-csv

            $.ajax({
                url: apiURL,
                crossDomain: true,
                dataType: "json",
                success: function (data) {
                    console.log(data)

                },
                error: function (jqXHR, textStatus, err) {
                    alert(jqXHR.responseText);
                }
            });
        }

</script>
 -->