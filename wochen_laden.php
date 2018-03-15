<?php
require("datenbank.php");
$laden=$_REQUEST["laden"];
$befehl = "select rechnung.datum,ausgaben.bezeichnung,ausgaben.betrag from ausgaben
 join rechnung on rechnung.id = ausgaben.rechnungsnr
 join laden on laden.id = rechnung.laden
 where week(rechnung.datum) = week(current_date)
 and laden.name = 'aldi';";
$result = $db->query($befehl);
$einkaeufe = $result->fetchAll();
print "<table border=1px>"; 
print "<tr><th>Datum</th><th>bezeichnung</th><th>Betrag</th></tr>";
foreach($einkaeufe as $zeile)
{
    print "<tr>";
    print "<td>".$zeile['datum']."</td>";
    print "<td>".$zeile['bezeichnung']."</td>";
    print "<td>".$zeile['betrag']."</td>";
    print "</tr>";
}

print "</table>";
?>