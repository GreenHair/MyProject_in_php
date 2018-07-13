<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Einkommen</title>+
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>
<body>
    <header>Haushaltsbuch</header>
    <h3>Einkommen</h3>
    <nav>
        <a href='index.php'><button>Diese Woche</button></a>
        <a href='index.php?Periode=LetzteWoche'><button>Letzte Woche</button></a>
        <a href='index.php?Periode=DiesenMonat'><button>Diesen Monat</button></a>
        <a href='index.php?Periode=LetztenMonat'><button>Letzen Monat</button></a>
        <a href="index.php?eintragen"><button>Eintragen</button></a>
        <a href="index.php?suchen"><button>Suchen</button></a>
        <a href="index.php?logout"><button>Logout</button></a>
    </nav>
    <?php
        require_once("datenbank.php");

        $befehl = "select monthname(datum) as monat, year(datum) as jahr from einkommen group by year(datum),monat order by datum desc";
        $monaten = $db->query($befehl);

        foreach($monaten as $monat)
        {
            $sql = "select unix_timestamp(datum) as datum,bezeichnung,betrag from einkommen where monthname(datum) = '".$monat['monat']."' and year(datum) = ".$monat['jahr'];
            $tabelle = $db->query($sql);
            $summe = 0.0;
            echo "<br><table>"; 
            echo "<caption>".$monat['monat']."</caption>"; 
            echo "<tr><th>Datum</th><th>Bezeichnung</th><th>Betrag</th></tr>";
            foreach($tabelle as $zeile)
            {
                echo "<tr><td>".date("d.m.y",$zeile['datum'])."</td><td>".$zeile['bezeichnung']."</td><td>".number_format($zeile['betrag'],2)."€</td></tr>";
                $summe += $zeile['betrag'];
            }
            echo "<tr><td></td><td></td></tr>";
            echo "<tr><td>Summe</td><td></td><td>".number_format($summe,2)."€</td></tr>";

            echo "</table>";
        }

        $db = null;
    ?>
</body>
</html>