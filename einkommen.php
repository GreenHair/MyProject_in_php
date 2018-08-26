<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Einkommen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>
<body>
    <header>Haushaltsbuch</header>
    <h3>Einkommen</h3>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class='navbar-brand' href='index.php'>Diese Woche</a>
            <a class='navbar-brand' href='index.php?Periode=LetzteWoche'>Letzte Woche</a>
            <a class='navbar-brand' href='index.php?Periode=DiesenMonat'>Diesen Monat</a>
            <a class='navbar-brand' href='index.php?Periode=LetztenMonat'>Letzen Monat</a>
            <a class='navbar-brand' href="index.php?eintragen">Eintragen</a>
            <a class='navbar-brand' href="index.php?suchen">Suchen</a>
            <a class='navbar-brand' href="index.php?logout">Logout</a>
        </div>
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
            echo "<br><fieldset>
            <legend>".$monat['monat']."</legend>
            <table class='income display compact'> 
            <thead>
                <tr><th>Datum</th><th>Bezeichnung</th><th>Betrag</th></tr>
            </thead>
            <tbody>";
            foreach($tabelle as $zeile)
            {
                echo "<tr><td>".date("d.m.y",$zeile['datum'])."</td><td>".$zeile['bezeichnung']."</td><td>".number_format($zeile['betrag'],2)."€</td></tr>";
                $summe += $zeile['betrag'];
            }
            echo "<tr><td>Summe</td><td></td><td>".number_format($summe,2)."€</td></tr>
            </tbody>
            </table>";
            echo "</fieldset>";
        }

        $db = null;
    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script>
        $('.income').DataTable();
    </script>
</body>
</html>