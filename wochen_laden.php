<!DOCTYPE html>
<html>
    <!--
<head>
    <meta charset="utf-8" />
    <title>Details</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
</head>
-->
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <title>Detail Übersicht</title>
  </head>

<body>
<header>Haushalt</header>
    <nav>
        <a href="index.php"><button>Diese Woche</button></a>
        <a href='index.php?Periode=LetzteWoche'><button>Letzte Woche</button></a>
        <a href='index.php?Periode=DiesenMonat'><button>Diesen Monat</button></a>
        <a href='index.php?Periode=LetztenMonat'><button>Letzen Monat</button></a>
        <a href="index.php?einkommen"><button>Einkommen</button></a>
        <a href="index.php?eintragen"><button>Eintragen</button></a>
        <a href="index.php?suchen"><button>Suchen</button></a>
        <a href="index.php?logout"><button>Logout</button></a>
    </nav>
 
   

<?php
require("modaltest.html");
require("datenbank.php");

if(isset($_REQUEST["Periode"]))
{
    switch($_REQUEST["Periode"])
    {
        case "DieseWoche":
            $_abschnitt = "week(rechnung.datum,1) = week(current_date,1) and year(rechnung.datum) = year(current_date)";
            break;
        case "LetzteWoche": 
            $_abschnitt = "week(rechnung.datum,1) = week(current_date,1)-1 and year(rechnung.datum) = year(current_date)";
            break;
        case "DiesenMonat": 
            $_abschnitt = "month(datum) = month(current_date) and year(rechnung.datum) = year(current_date)";
            break;
        case "LetztenMonat": 
            $_abschnitt = "month(datum) = month(current_date)-1 and year(rechnung.datum) = year(current_date)";
            break;
    }
}
else
{
    $_abschnitt = "week(rechnung.datum,1) = week(current_date,1)";
}

if(isset($_REQUEST["laden"]))
{
	//$periode = $_REQUEST["Periode"];
    $laden=$_REQUEST["laden"];

    $befehl = "SELECT rechnung.datum FROM rechnung 
    JOIN laden on laden.id = rechnung.laden WHERE ".$_abschnitt."
    and laden.name = ?;";
    $stmt = $db->prepare($befehl);
    $stmt->execute(array($laden));
    $result = $stmt->fetchAll();
    
    echo "<h3>$laden</h3>";

    foreach($result as $date)
    {
        echo "<br><fieldset>
        <legend>".date("l d-m-y",strtotime($date['datum']))."</legend>";

        $befehl = "select rechnung.id as r_id, ausgaben.id as a_id,rechnung.datum,ausgaben.bezeichnung,ausgaben.betrag from ausgaben
        join rechnung on rechnung.id = ausgaben.rechnungsnr
        join laden on laden.id = rechnung.laden
        where datum='".$date['datum']."'
        and laden.name = ?;";
        $stmt = $db->prepare($befehl);
        $stmt->execute(array($laden));
        $einkaeufe = $stmt->fetchAll();
        showTable($einkaeufe);

        echo "</fieldset>";
    }
    //$stmt = null;
}

if(isset($_REQUEST["kategorie"]))
{
	//$periode = $_REQUEST["Periode"];
    $kategorie = $_REQUEST["kategorie"];

    $befehl = "SELECT DISTINCT rechnung.datum FROM rechnung 
    JOIN ausgaben ON rechnung.id = ausgaben.rechnungsnr 
    JOIN produktgruppe ON produktgruppe.ID = ausgaben.prod_gr 
    WHERE ".$_abschnitt."
    AND produktgruppe.bezeichnung = ?;";

    $stmt = $db->prepare($befehl);
    $stmt->execute(array($kategorie));
    $result = $stmt->fetchAll();

    echo "<h3>$kategorie</h3>";

    foreach($result as $date)
    {
        echo "<br><fieldset>
        <legend>".date("l d-m-y",strtotime($date['datum']))."</legend>";

        $befehl = "select rechnung.id as r_id, ausgaben.id as a_id,rechnung.datum,ausgaben.bezeichnung,ausgaben.betrag from ausgaben
        join rechnung on rechnung.id = ausgaben.rechnungsnr
        join produktgruppe on produktgruppe.ID = ausgaben.prod_gr
        where datum = '".$date["datum"]."'
        and produktgruppe.bezeichnung = ?;";
        $stmt = $db->prepare($befehl);
        $stmt->execute(array($kategorie));
        $einkaeufe = $stmt->fetchAll();
        showTable($einkaeufe);

        echo "</fieldset>";
    }
}

if(isset($_REQUEST["wochentag"]))
{
    $datum=$_REQUEST["wochentag"];
    $befehl = "select laden.id as l_id,name,rechnung.id as r_id from laden
     join rechnung on rechnung.laden = laden.id
     where rechnung.datum = ?";
    $stmt = $db->prepare($befehl);
    $stmt->execute(array($datum));
    $shops = $stmt->fetchAll();
    foreach($shops as $laden)
    {
        print "<br><fieldset>";
        print "<legend>".$laden['name']."</legend>";
    
        $befehl = "select rechnung.id as r_id, ausgaben.id as a_id,rechnung.datum,ausgaben.bezeichnung,ausgaben.betrag from ausgaben
        join rechnung on rechnung.id = ausgaben.rechnungsnr
        where rechnung.id = ".$laden["r_id"];/*
        datum = ?
        and rechnung.laden = ".$laden['id'];*/
        $stmt = $db->prepare($befehl);
        $stmt->execute(array($datum));
        $einkaeufe = $stmt->fetchAll();
        showTable($einkaeufe);
        echo "</fieldset>";
    }
}

print "<a href='".$_SERVER['HTTP_REFERER']."'><button>zurück</button></a>";

function showTable($ware)
{
    $summe = 0.0;
    print "<table class='einkaeufe display compact'>";
    print "<thead>
            <tr><th>r_id</th><th>a_id</th><th>Datum</th><th>Bezeichnung</th><th>Betrag</th><th></th></tr>
        </thead>
        <tbody>";
    foreach($ware as $zeile)
    {
        print "<tr>";
        print "<td>".$zeile['r_id']."</td><td>".$zeile['a_id']."</td>";
        print "<td>".date("l d-m-y",strtotime($zeile['datum']))."</td>";
        print "<td>".$zeile['bezeichnung']."</td>";
        print "<td>".number_format($zeile['betrag'],2)."€</td>";
        print "<td><button type='button' data-toggle='modal' data-target='#modal_update' class='btnEdit' style='margin-left:20px'><i class='material-icons'>edit</i></button></td>";
        print "</tr>";
        $summe += $zeile['betrag'];
    }
    print "<tr><td></td><td></td><td></td><td>Gesamt</td><td>".number_format($summe,2)."€</td><td></td></tr>
    </tbody>
    </table>
    <br>";
}

$stmt = null;
$db = null;
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
   <script>
    $(document).ready(function() {
        var table =  $('.einkaeufe').DataTable({
            "ordering" : false,
            "paging" : false,
            "columns": [
                {"visible": false, "data": "r_id"},
                {"visible": false, "data": "a_id"},
                {"data": "datum"},
                {"data": "bezeichnung"},
                {"data": "betrag"},
                {"orderable": false}
            ]
         } );

        $('.einkaeufe tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        } )

        $('#modal_update').on('shown.bs.modal',function(e){
            var data = table.rows('.selected').data();
            console.log(data);
            $('#modal_a_id').val(data[0].a_id);
            $('#modal_bezeichnung').val(data[0].bezeichnung);
            $('#modal_betrag').val(data[0].betrag);
            console.log(data[0].bezeichnung);
        });
    });
   </script>
   </body>
</html>