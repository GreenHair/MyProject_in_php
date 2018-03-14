<?php
try
{
    $connString = "mysql:host=127.0.0.1;port=3306;dbname=haushaltsbuch";

    $db = new PDO($connString, "root", "");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $error)
{
	print "Keine Verbindung";
	print "<br/>";
	print "Fehlercode: ".$error->getCode();
	print "<br/>";
	print "Nachricht: ".$error->getMessage();
}

/* $befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr where week(datum,1) = week(current_date,1) and einmalig = 1;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche = $daten["summe"];

$befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.id = ausgaben.prod_gr where week(datum,1) = week(current_date,1) and einmalig = 1 and produktgruppe.essen = 1;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche_essen = $daten["summe"];

$befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.id = ausgaben.prod_gr where week(datum,1) = week(current_date,1) and einmalig = 1 and produktgruppe.essen = 0;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche_sontiges = $daten["summe"];

$befehl = "select produktgruppe.bezeichnung, sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.ID = ausgaben.prod_gr where week(rechnung.datum,1) = week(current_date,1) and rechnung.einmalig = 1 group by produktgruppe.bezeichnung order by summe desc;";
$result = $db->query($befehl);
$kategorien = $result->fetchAll();


$db = null; */
?>