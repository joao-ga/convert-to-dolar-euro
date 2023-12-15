<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Resultado</title>
</head>
<body>
    <header>
        <h1>Resultado do Processamento</h1>
    </header>
    <main>
        <?php 
            //definir a data atual
            $inicio = date("m-d-Y", strtotime("-7 days")) ;
            $fim = date("m-d-Y"); 

            //cotacao da api para euro
            $urlEUR = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda=\'EUR\'&@dataInicial=\''. $inicio.'\'&@dataFinalCotacao=\''. $fim.'\'&$top=1&$format=json&$select=cotacaoCompra';

            $dadosEUR = json_decode(file_get_contents($urlEUR), true);

            $cotacaoEUR = $dadosEUR["value"][0]["cotacaoCompra"];

            //definir a data atual
            $inicio2 = date("m-d-Y", strtotime("-7 days")) ;
            $fim2 = date("m-d-Y"); 

            //cotacao da API para dolar
            $urlDOL = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio2.'\'&@dataFinalCotacao=\''. $fim2.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

            $dadosDOL = json_decode(file_get_contents($urlDOL), true);

            $cotacaoDOL = $dadosDOL["value"][0]["cotacaoCompra"];

            //valor digitado pelo usuario
            $saldo1 = $_GET["numero"] ?? 0;

            $conversaoDOL = $saldo1 / $cotacaoDOL;
            $conversaoEUR = $saldo1 / $cotacaoEUR;

            echo "Seus R$ " . number_format($saldo1, 2, ",", ".") .  " valem US$ " . number_format($conversaoDOL, 2, ",", "."). " e valem EUR$ " . number_format($conversaoEUR, 2, ",", ".");

        ?>
        <p><a href="javascript:history.go(-1)">Voltar para pagina anterior</a></p>
    </main>
</body>
</html>

