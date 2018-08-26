<?php
try
{
    $connString = "mysql:host=192.168.2.113;port=3306;dbname=haushaltsbuch;charset=utf8";

    $db = new PDO($connString, "auke", "ich");

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
/* if($db != null)
{
	$result = $db->query("select * from laden");
	$laden = $result->fetchAll();
	$result = $db->query("select * from familienmitglied");
	$person = $result->fetchAll();
	$result = $db->query("select * from produktgruppe");
	$kategorieen = $result->fetchAll();
} */

function GetLaden($db)
{
	$result = $db->query("select * from laden");
	$shops = $result->fetchAll();
	return $shops;
}

function GetFamilie($db)
{
	$result = $db->query("select * from familienmitglied");
	$fam = $result->fetchAll();
	return $fam;
}

function GetKategorieen($db)
{
	$result = $db->query("select * from produktgruppe");
	$kategorie = $result->fetchAll();
	return $kategorie;
}

function GetBalance($db,$month)
{
	$sql = "SELECT (SELECT SUM(einkommen.betrag) FROM einkommen WHERE MONTH(datum) = ? AND YEAR(datum) = YEAR(CURRENT_DATE)) - SUM(ausgaben.betrag) as balance from ausgaben
	JOIN rechnung ON rechnung.id = ausgaben.rechnungsnr
	WHERE MONTH(rechnung.datum) = ? AND
	YEAR(rechnung.datum) = YEAR(CURRENT_DATE)";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($month,$month));
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	return $result["balance"];
}
?>