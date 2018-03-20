<?php
require("wochenuebersicht.php");
/* header('Content-type: text/html; charset=utf-8'); */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />    
    <title>Haushalt</title>    
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />    
    <?php
    print "<style>@keyframes wachsen1{
        from{height: 0px;}
        to{height: ".$gesamt_woche."px}}
        @keyframes wachsen2{
            from{height: 0px;}
            to{height".$gesamt_woche_essen."px}}
        @keyframes wachsen3{
            from{height: 0px}
            to{height".$gesamt_woche_sontiges."px}}
        </style>"
    ?>
</head>
<body>
    <header>Haushalt</header>
    <h3>Diese Woche</h3>
    <nav>
        <!-- <ul>
            <li><a href="eintragen.php"><button>Eintragen</button></a></li>
        </ul> -->
        <a href="eintragen.php"><button>Eintragen</button></a>
    </nav>
    
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
    <br>
    <fieldset>
        <legend>Kategorien</legend>
    <div>
        <table>
        <?php
        foreach($kategorien as $zeile)
        {
            print "<tr>"; 
            print "<td><a href='wochen_laden.php?kategorie=".$zeile["bezeichnung"]."'>".$zeile["bezeichnung"]."</a></td>";
            $width = $zeile['summe'] * 10;
            print "<td><div class='kategorien' style='width: ".$width."px'></div>";
            print number_format($zeile["summe"],2)."€<td>";
            print "</tr>";
        }
        ?>
        </table>
    </div>
    </fieldset>
    <br>
    <fieldset>
        <legend>Läden</legend>
        <div>
            <table>
            <?php
                foreach($laeden as $zeile)
                {
                    print "<tr>"; 
                    print "<td><a href='wochen_laden.php?laden=".$zeile["name"]."'>".$zeile["name"]."</a></td>";
                    $width = $zeile['summe'] * 10;
                    print "<td><div class='kategorien' style='width: ".$width."px'></div>";
                    print number_format($zeile["summe"],2)."€<td>";
                    print "</tr>";
                }
            ?>
            </table>
        </div>
    </fieldset>
    <br>
    <fieldset>
        <legend>Wochentage</legend>
        <table>
            <tr><th>Tag</th><th>Betrag</th></tr>
            <?php
                foreach($wochentag as $zeile)
                {
                    print "<tr><td><a href='wochen_laden.php?wochentag=".$zeile['datum']."'>".date("l",strtotime($zeile['datum']))."</a></td>";
                    print "<td>".number_format($zeile['summe'],2)."</td></tr>";
                }
            ?>
        </table>
    </fieldset>
</body>
</html>