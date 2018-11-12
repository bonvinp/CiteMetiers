<?php
/*
Auteur  : Lopes Miguel, Troller Fabian, Juling Guntram
Date    : 2018.11.06
Description : Code javascript cité des metiers
 */

include("solution.php");
$solution = getSolutionJSON();

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date dans le passé
?>
<!DOCTYPE html>
<html>
<head>

    <title>Cité des métiers | Binary</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <script>var ADDR = JSON.parse('<?= json_encode(ADDR) ?>');
        var solution = JSON.parse('<?= json_encode($solution) ?>');</script>
    <script src="./binary.js?d=<?php echo date('hms',time()); ?>"></script>
</head>

<body class="text-center" style="font-size: 2.5em;">
<main class="container-fluid">
    <section class="col-md-6">
        <div class="col-md-6">
            <div class="row">
                <span class="solutions" id="sol0">?</span>
            </div>
            <div class="row">
                <p>
                    &nbsp;2<sup>3</sup>&nbsp;
                    &nbsp;2<sup>2</sup>&nbsp;
                    &nbsp;2<sup>1</sup>&nbsp;
                    &nbsp;2<sup>0</sup>&nbsp;
                </p>
            </div>
            <div class="row binary">
                <hr>
                <?php
                for ($i = 0; $i < 4; $i++)
                    echo '&nbsp;<span id="value' . $i . '">_</span>&nbsp;';
                ?>
                <hr>
            </div>
            <div class="row hexadecimal">
                <span id="hex0">0</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <span class="solutions" id="sol1">?</span>
            </div>
            <div class="row">
                <p>
                    &nbsp;2<sup>3</sup>&nbsp;
                    &nbsp;2<sup>2</sup>&nbsp;
                    &nbsp;2<sup>1</sup>&nbsp;
                    &nbsp;2<sup>0</sup>&nbsp;
                </p>
            </div>
            <div class="row binary">
                <hr>
                <?php
                for ($i = 4; $i < 8; $i++)
                    echo '&nbsp;<span id="value' . $i . '">_</span>&nbsp;';
                ?>
                <hr>
            </div>
            <div class="row hexadecimal">
                <span id="hex1">0</span>
            </div>
        </div>
    </section>
    <section class="col-md-6">
        <div class="row">
            <br>
        </div>
        <br>
        <div class="row">
            <span id="message">Veuillez entrer le code</span>
        </div>
        <br>
        <div class="row">
            <form method="post" action="">
                <div class="col-md-6 col-md-offset-3">
                    <div class="row">
                        <div class="col-md-6">
                            <input disabled value="0" type="Button" style="height: 100px" onclick="ListSetter(0)" id="B0" class="btn btn-lg btn-block btn-primary"/>
                        </div>
                        <div class="col-md-6">
                            <input disabled value="1" type="Button" style="height: 100px" onclick="ListSetter(1)" id="B1" class="btn btn-lg btn-block btn-primary"/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input disabled value="Effacer" type="Button" style="height: 50px" onclick="ResetArray()" id="B2" class="btn btn-lg btn-block btn-danger"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
</body>

</html>
