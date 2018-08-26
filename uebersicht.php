<?php
if (isset($_REQUEST["Periode"])) {
    switch ($_REQUEST["Periode"]) {
        case "LetzteWoche":
            $abschnitt = "LetzteWoche";
            $bilanz_visibility = "hidden";
            require("wochenuebersicht.php");
     /*       $navbar = "<li class='nav-item'><a class='navbar-brand' href='index.php'>Diese Woche</a></li>
            <li class='nav-item'><a class='navbar-brand' href='index.php?Periode=DiesenMonat'>Diesen Monat</a></li>
            <li class='nav-item'><a class='navbar-brand' href='index.php?Periode=LetztenMonat'>Letzen Monat</a></li>";
       */ $navbar = "<a class='navbar-brand' href='index.php'>Diese Woche</a>
       <a class='navbar-brand' href='index.php?Periode=DiesenMonat'>Diesen Monat</a>
       <a class='navbar-brand' href='index.php?Periode=LetztenMonat'>Letzen Monat</a>";
           $titel = "Letzte Woche";
            break;
        case "DiesenMonat":
            $abschnitt = "DiesenMonat";
            $bilanz_visibility = "visible";
            $month = date("m");
            require("wochenuebersicht.php");
            $navbar = "<a class='navbar-brand' href='index.php'>Diese Woche</a>
            <a class='navbar-brand' href='index.php?Periode=LetzteWoche'>Letzte Woche</a>
            <a class='navbar-brand' href='index.php?Periode=LetztenMonat'>Letzen Monat</a>";
            $titel = "Diesen Monat";
            break;
        case "LetztenMonat":
            $abschnitt = "LetztenMonat";
            $bilanz_visibility = "visible";
            $month = date("m") - 1;
            require("wochenuebersicht.php");
            $navbar = "<a class='navbar-brand'  href='index.php'>Diese Woche</a>
            <a class='navbar-brand'  href='index.php?Periode=LetzteWoche'>Letzte Woche</a>
            <a class='navbar-brand'  href='index.php?Periode=DiesenMonat'>Diesen Monat</a>";
            $titel = "Letzten Monat";
            break;
    }
} else {
    $abschnitt = "DieseWoche";
    $bilanz_visibility = "hidden";
    require("wochenuebersicht.php");
    $navbar = "<a class='navbar-brand'  href='index.php?Periode=LetzteWoche'>Letzte Woche</a>
    <a class='navbar-brand'  href='index.php?Periode=DiesenMonat'>Diesen Monat</a>
    <a class='navbar-brand'  href='index.php?Periode=LetztenMonat'>Letzen Monat</a>";
    $titel = "Diese Woche";
}

/* header('Content-type: text/html; charset=utf-8'); */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Haushalt</title>    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/af-2.3.0/b-1.5.2/b-html5-1.5.2/kt-2.4.0/r-2.2.2/datatables.min.css"/>
    
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" /> 
    
    <?php
    print "<style>
        @keyframes wachsen1{
            from{height: 0px;}
            to{height: " . $gesamt_woche . "px}}
            @keyframes wachsen2{
                from{height: 0px;}
                to{height" . $gesamt_woche_essen . "px}}
            @keyframes wachsen3{
                from{height: 0px}
                to{height" . $gesamt_woche_sontiges . "px}}

        .bilanz{
            visibility:$bilanz_visibility;
        }
        .positiv{
            color:green;
        }
        .negativ{
            color:red;
        }
        </style>"
    ?>
    
    
</head>
<body>
    <header>Haushalt</header>
    <h3><?php print $titel ?></h3>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!--<ul class="navbar-nav">-->
            
            <?php print $navbar; ?>
            <a class='navbar-brand' href="index.php?einkommen">Einkommen</a>
         <!--   </ul> -->
        
            
            <a class='navbar-brand' href="index.php?eintragen">Eintragen</a>
            <a class='navbar-brand' href="index.php?suchen">Suchen</a>
            <a class='navbar-brand' href="index.php?logout">Logout</a>
        </div>
    </nav>
    
    <div id="main">
        <div>
            <?php print number_format($gesamt_woche, 2) . "€";
            print "<div style='height: " . $gesamt_woche . "px'></div>";
            ?>
            gesamt
        </div>
        <div>
            <?php print number_format($gesamt_woche_essen, 2) . "€";
            print "<div style='height: " . $gesamt_woche_essen . "px'></div>";
            ?>
            essen
        </div>
        <div>
            <?php print number_format($gesamt_woche_sontiges, 2) . "€";
            print "<div style='height: " . $gesamt_woche_sontiges . "px'></div>";
            ?>
            sontiges
        </div>
        <div class="bilanz">
            Bilanz:
            <span class=<?php echo $bilanz > 0 ? "'positiv'" : "'negativ'"; ?>><?php print number_format($bilanz,2) ?>€</span>
        </div>
    </div>
    <br>
    <fieldset>
        <legend>Kategorien</legend>
    <div>
        <table>
        <?php
        foreach ($kategorien as $zeile) {
            print "<tr>";
            print "<td><a href='wochen_laden.php?kategorie=" . $zeile["bezeichnung"] . "&Periode=" . $abschnitt . "'>" . $zeile["bezeichnung"] . "</a></td>";
            $width = $zeile['summe'] * 10;
            print "<td><div class='kategorien' style='width: " . $width . "px'></div>";
            print number_format($zeile["summe"], 2) . "€<td>";
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
            foreach ($laeden as $zeile) {
                print "<tr>";
                print "<td><a href='wochen_laden.php?laden=" . $zeile["name"] . "&Periode=" . $abschnitt . "'>" . $zeile["name"] . "</a></td>";
                $width = $zeile['summe'] * 10;
                print "<td><div class='kategorien' style='width: " . $width . "px'></div>";
                print number_format($zeile["summe"], 2) . "€<td>";
                print "</tr>";
            }
            ?>
            </table>
        </div>
    </fieldset>
    <br>
    <fieldset>
        <legend>Wochentage</legend>
        <table id="woche" class="display">
            <thead><tr><th>Datum</th><th>Tag</th><th>Betrag</th></tr></thead>
            <tbody>
            <?php
            foreach ($wochentag as $zeile) {
                print "<tr><td><a href='wochen_laden.php?wochentag=" . $zeile['datum'] . "'>" . date("d.m.y", strtotime($zeile['datum'])) . "</a></td>";
                print "<td><a href='wochen_laden.php?wochentag=" . $zeile['datum'] . "'>" . date("l", strtotime($zeile['datum'])) . "</a></td>";
                print "<td>" . number_format($zeile['summe'], 2) . "€</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </fieldset>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/af-2.3.0/b-1.5.2/b-html5-1.5.2/kt-2.4.0/r-2.2.2/datatables.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>            
   
    <script>
        $(document).ready(function() {
            $('#woche').DataTable({
                "ordering" : false
            });
        });
</script>
</body>
</html>