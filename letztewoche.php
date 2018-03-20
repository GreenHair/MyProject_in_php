<?php
require("datenbank.php");

$befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr where week(datum,1) = week(current_date,1)-1 and einmalig = 1;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche = $daten["summe"];

$befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.id = ausgaben.prod_gr where week(datum,1) = week(current_date,1)-1 and einmalig = 1 and produktgruppe.essen = 1;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche_essen = $daten["summe"];

$befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.id = ausgaben.prod_gr where week(datum,1) = week(current_date,1)-1 and einmalig = 1 and produktgruppe.essen = 0;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche_sontiges = $daten["summe"];

$befehl = "select produktgruppe.bezeichnung, sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.ID = ausgaben.prod_gr where week(rechnung.datum,1) = week(current_date,1)-1 and rechnung.einmalig = 1 group by produktgruppe.bezeichnung order by summe desc;";
$result = $db->query($befehl);
$kategorien = $result->fetchAll();

$befehl = "select laden.name, sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join laden on rechnung.laden = laden.ID where week(rechnung.datum,1) = week(current_date,1)-1 and rechnung.einmalig = 1 group by laden.name order by summe desc;";
$result = $db->query($befehl);
$laeden = $result->fetchAll();

$befehl = " select datum, sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr where week(datum,1) = week(current_date,1)-1 group by datum;";
$result = $db->query($befehl);
$wochentag = $result->fetchAll();

$db = null;
?>