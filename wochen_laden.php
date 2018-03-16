<?php
require("datenbank.php");
if(isset($_REQUEST["laden"]))
{
    $laden=$_REQUEST["laden"];
    $befehl = "select rechnung.datum,ausgaben.bezeichnung,ausgaben.betrag from ausgaben
    join rechnung on rechnung.id = ausgaben.rechnungsnr
    join laden on laden.id = rechnung.laden
    where week(rechnung.datum,1) = week(current_date,1)
    and laden.name = ?;";
    $stmt = $db->prepare($befehl);
    $stmt->execute(array($laden));
    $einkaeufe = $stmt->fetchAll();
    showTable($einkaeufe);
}

if(isset($_REQUEST["kategorie"]))
{
    $kategorie = $_REQUEST["kategorie"];
    $befehl = "select rechnung.datum,ausgaben.bezeichnung,ausgaben.betrag from ausgaben
    join rechnung on rechnung.id = ausgaben.rechnungsnr
    join produktgruppe on produktgruppe.ID = ausgaben.prod_gr
    where week(rechnung.datum,1) = week(current_date,1)
    and produktgruppe.bezeichnung = ?;";
    $stmt = $db->prepare($befehl);
    $stmt->execute(array($kategorie));
    $einkaeufe = $stmt->fetchAll();
    showTable($einkaeufe);
}

print "<a href='".$_SERVER['HTTP_REFERER']."'>zurück</a>";

function showTable($ware)
{
    print "<table border=1px>"; 
    print "<tr><th>Datum</th><th>bezeichnung</th><th>Betrag</th></tr>";
    foreach($ware as $zeile)
    {
        print "<tr>";
        print "<td>".date("l d-m-y",strtotime($zeile['datum']))."</td>";
        print "<td>".$zeile['bezeichnung']."</td>";
        print "<td>".$zeile['betrag']."</td>";
        print "</tr>";
    }
    print "</table>";
}

$db = null;
?>