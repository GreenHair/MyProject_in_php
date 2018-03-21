<?php
require("datenbank.php");
if(!empty($_REQUEST["datum"]) && !empty($_REQUEST["bezeichnung"]))
{
    if(empty($_REQUEST["einmal"]))
    {
        $einmal = 0;
    }
    else
    {
        $einmal = 1;
    }
    $befehl =  "insert into rechnung(datum,laden,person,einmalig) values ('".$_REQUEST["datum"]."',".$_REQUEST['laden'].",".$_REQUEST["person"].",".$einmal.");";
    $result1 = $db->exec($befehl);

    $werte = array();
    $befehl = "insert into ausgaben(bezeichnung,betrag,prod_gr,rechnungsnr) values ";
    for($i = 0; $i < count($_REQUEST["bezeichnung"]); $i++)
    {
        if(strlen($_REQUEST["bezeichnung"][$i]) != 0)
        {
            $befehl .= "(?,?,?,last_insert_id()),";
            $werte[] = $_REQUEST["bezeichnung"][$i];
            $werte[] = str_ireplace(",",".",$_REQUEST["preis"][$i]);
            $werte[] = $_REQUEST["kat"][$i];
        }
    }
    $sql = rtrim($befehl,",");
    $stmt = $db->prepare($sql);
    $result2 = $stmt->execute($werte);

    print $result1." rows affected<br>";
    print $result2." rows affected<br>";
}
else
{
    print "Keine Daten zum Eintragen<br>";
}

print "<a href='".$_SERVER["HTTP_REFERER"]."'>zurück</a><br>";
print "<a href='index.php'>Übersicht</a>";

 $db = null;
?>