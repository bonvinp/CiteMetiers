<?php
include("Soluce.php");
$solution = getSolutionJSON();

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date dans le passé
?>
<!DOCTYPE html>
<html>
<head>

    <title>Bouton</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <script>var ADDR = JSON.parse('<?= json_encode(ADDR) ?>');</script>
    <script src="./javascript.js"></script>
</head>

<body class="text-center">
<div class="row">
    <div class="col-sm-7">

        <!-- start -->
        <div class="row">
            <div class="col">
                <table border="solid" class="table" id="TablePow1">
                    <tr>
                        <?php
                        for ($i = 3; $i >= 0; $i--) { ?>
                            <td>2<sup><?php print($i); ?></sup></td>
                            <?php
                        }
                        ?>
                    </tr>
                </table>
            </div>
            <div class="col">
                <table border="solid" class="table" id="TablePow2">
                    <tr>
                        <?php
                        for ($i = 3; $i >= 0; $i--) { ?>
                            <td>2<sup><?php print($i); ?></sup></td>
                            <?php
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
        <!-- end -->
        <!-- start -->
        <div class="row">
            <div class="col">
                <table border="solid" id="Table1" class="table">
                    <tr>

                        <?php
                        for ($i = 0; $i < 8; $i++) {
                            if ($i == 4) {
                                print('</tr></table></div><div class="col"><table border="solid" id="Table2" class="table"><tr>');
                            } ?>
                            <td>
                                <?php print('<div id="value' . $i . '">_</div>'); ?>
                            </td>
                        <?php }

                        ?>
                    </tr>
                </table>
            </div>
        </div>
        <!-- end -->
        <!-- start -->
        <div class="row">
            <div class="col">
                <table border="solid" id="TableHex1" class="table">
                    <tr>
                        <?php
                        for ($i = 0; $i < 2; $i++) {
                            if ($i == 1) {
                                print('</tr></table></div><div class="col"><table border="solid" id="TableHex2" class="table"><tr>');
                            } ?>
                            <td>
                                <?php print('<div id="hex' . $i . '">0</div>'); ?>
                            </td>
                        <?php } ?>
                    </tr>
                </table>
            </div>
        </div>
        <!-- end -->
    </div>
    <div class="col-sm-5 align-items-start flex-column">
        <!-- start -->
        <form method="post" action="serveur.php">
            <div class="row">
                <input type="Button" value="X" name="Delete" onclick="ResetArray()" id="X"
                       class="btn btn-secondary w-100"/>
                <div class="w-100 col">
                    <!-- start -->
                    <div>
                        <div class="col">
                            <table class="table mt-2" id="TableSol1">
                                <th style="border:none;">Résultat :</th><th style="border:solid 1px;"><div id="sol0"><?php print($solution[0]);?></div> <div id="sol1"><?php print($solution[1]);?></div>
                                </th>
                            </table>
                        </div>
                    </div>
                    <!-- end -->
                    <img src="img/cadena_ouvert.png" class="w-50 h-60" id="winimage" hidden/></div>
                <input type="Button" value="0" name="Button" onclick="ListSetter(0)" id="B0"
                       class="btn btn-secondary w-100 mb-1"/>
                <input type="Button" value="1" name="Button" onclick="ListSetter(1)" id="B1"
                       class="btn btn-secondary w-100"/>
            </div>

        </form>
        <!-- end -->
    </div>
</div>
</body>

</html>
