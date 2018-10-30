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
    <script src="js/bootstrap.min.js"></script>

    <script>var ADDR = JSON.parse('<?= json_encode(ADDR) ?>');</script>
    <script src="./javascript.js"></script>
</head>

<body class="text-center">
<div class="row">
    <div class="col-sm-7">
        <!-- start -->
        <div class="row">
            <div class="col">
                <table border="solid" class="table" id="TableSol1">
                    <tr>
                        <?php
                        if (isset($solution)) {
                            for ($i = 0; $i < count($solution); $i++) {
                                if ($i == 1) {
                                    print('</tr></table></div><div class="col"><table border="solid"  class="table" id="TableSol2"><tr>');
                                } ?>
                                <td>
                                    <?php print('<div id="sol' . $i . '">' . $solution[$i] . '</div>'); ?>
                                </td>
                            <?php }

                        } ?>
                    </tr>
                </table>
            </div>
        </div>
        <!-- end -->
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
                <div class="mb-auto p-2">
                    <input type="Button" value="X" name="Delete" onclick="ResetArray()" id="X"
                                         class="btn btn-secondary w-100 mb-5"/>
                </div>

                <div class="p-2">
                    <input type="Button" value="0" name="Button" onclick="ListSetter(0)" id="B0"
                       class="btn btn-secondary w-100 mb-1"/>
                </div>
                <div class="p-2">
                    <input type="Button" value="1" name="Button" onclick="ListSetter(1)" id="B1"
                       class="btn btn-secondary w-100"/>
                </div>
            </div>

        </form>
        <!-- end -->
    </div>
</div>
</body>

</html>
