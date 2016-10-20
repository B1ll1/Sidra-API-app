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

    </head>
    <body>
    </body>
</html>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">

        var prodUF;
        var qtdProdUF;
        var anoPAM;
        var tabelaSidra = 1612;
        var classificacaoLavouraSidra = 81;

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
            var apiURL = "https://crossorigin.me/http://www.sidra.ibge.gov.br/api/values/h/n/t/" + tabelaSidra + "/c" + classificacaoLavouraSidra + "/allxt/n3/all/p/last/v/214";

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
