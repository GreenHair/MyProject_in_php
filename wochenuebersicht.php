<?php
require_once("datenbank.php");
$periode = "";
if(isset($_REQUEST["Periode"]))
{
    switch($_REQUEST["Periode"])
    {
        case "DieseWoche":
            $periode = "week(rechnung.datum,1) = week(current_date,1) and year(rechnung.datum) = year(current_date)";
            break;
        case "LetzteWoche": 
            $periode = "week(rechnung.datum,1) = week(current_date,1)-1 and year(rechnung.datum) = year(current_date)";
            break;
        case "DiesenMonat": 
            $periode = "month(datum) = month(current_date) and year(rechnung.datum) = year(current_date)";
            break;
        case "LetztenMonat": 
            $periode = "month(datum) = month(current_date)-1 and year(rechnung.datum) = year(current_date)";
            break;
    }
}
else
{
    $periode = "week(rechnung.datum,1) = week(current_date,1) and year(rechnung.datum) = year(current_date)";
}

$befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr where ".$periode." and einmalig = 1;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche = $daten["summe"];

$befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.id = ausgaben.prod_gr where ".$periode." and einmalig = 1 and produktgruppe.essen = 1;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche_essen = $daten["summe"];

$befehl = "select sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.id = ausgaben.prod_gr where ".$periode." and einmalig = 1 and produktgruppe.essen = 0;";
$result = $db->query($befehl);
$daten = $result->fetch(PDO::FETCH_ASSOC);
$gesamt_woche_sontiges = $daten["summe"];

$befehl = "select produktgruppe.bezeichnung, sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join produktgruppe on produktgruppe.ID = ausgaben.prod_gr where ".$periode." and rechnung.einmalig = 1 group by produktgruppe.bezeichnung order by summe desc;";
$result = $db->query($befehl);
$kategorien = $result->fetchAll();

$befehl = "select laden.name, sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr join laden on rechnung.laden = laden.ID where ".$periode." and rechnung.einmalig = 1 group by laden.name order by summe desc;";
$result = $db->query($befehl);
$laeden = $result->fetchAll();

$befehl = "select datum, sum(betrag) as summe from ausgaben join rechnung on rechnung.id = ausgaben.rechnungsnr where ".$periode." group by datum;";
$result = $db->query($befehl);
$wochentag = $result->fetchAll();

$db = null;
?>