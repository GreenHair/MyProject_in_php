<?php
require("wochenuebersicht.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />    
    <title>Haushalt</title>    
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />    
</head>
<body>
    <header>Haushalt</header>
    <div id="main">
        <div>
            <?php print number_format($gesamt_woche,2)."€";
            print "<div style='height: ".$gesamt_woche."px'></div>";
            ?>
            gesamt
        </div>
        <div>
            <?php print number_format($gesamt_woche_essen,2)."€";
            print "<div style='height: ".$gesamt_woche_essen."px'></div>";
            ?>
            essen
        </div>
        <div>
            <?php print number_format($gesamt_woche_sontiges,2)."€";
            print "<div style='height: ".$gesamt_woche_sontiges."px'></div>";
            ?>
            sontiges
        </div>
    </div>
    <fieldset>
        <legend>Kategorien</legend>
    <div>
        <table>
        <?php
        foreach($kategorien as $zeile)
        {
            print "<tr>"; 
            print "<td>".$zeile["bezeichnung"]."</td>";
            $width = $zeile['summe'] * 10;
            print "<td><div class='kategorien' style='width: ".$width."px'></div>";
            print number_format($zeile["summe"],2)."€<td>";
            print "</tr>";
        }
        ?>
        </table>
    </div>
    </fieldset>
    <fieldset>
        <legend>Läden</legend>
        <div>
            <table>
            <?php
                foreach($laeden as $zeile)
                {
                    print "<tr>"; 
                    print "<td>".$zeile["name"]."</td>";
                    $width = $zeile['summe'] * 10;
                    print "<td><div class='kategorien' style='width: ".$width."px'></div>";
                    print number_format($zeile["summe"],2)."€<td>";
                    print "</tr>";
                }
            ?>
            </table>
        </div>
    </fieldset>
</body>
</html>