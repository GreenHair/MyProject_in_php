<?php
require("datenbank.php");

if(!empty($_REQUEST["bezeichnung"]) && !empty($_REQUEST["datum"]))
{
    $betrag = str_ireplace(",",".",$_REQUEST["betrag"]);
    $befehl = "insert into einkommen(datum,bezeichnung,person,betrag) values (?,?,?,?)";
    $stmt = $db->prepare($befehl);
    $stmt->execute(array($_REQUEST["datum"],$_REQUEST["bezeichnung"],$_REQUEST["person"],$betrag));
}
elseif(!empty($_REQUEST["laden_name"]) )
{
    $online = (empty($_REQUEST["online"]))? 0 : 1 ;
    $befehl = "insert into laden (name,online) values (?,?)";
    $stmt = $db->prepare($befehl);
    $stmt->execute(array($_REQUEST["laden_name"]),$online);
}
elseif(!empty($_REQUEST["produktgruppe"]))
{
    $essen = (empty($_REQUEST["essen"]))? 0 : 1 ;
    $befehl = "insert into produktgruppe (bezeichnung,essen) values (?,?)";
    $stmt = $db->prepare($befehl);
    $stmt->execute(array($_REQUEST["produktgruppe"],$essen));
}
else
{
    print "Keine Daten zum Eintragen<br>";
}

print "<a href='".$_SERVER["HTTP_REFERER"]."'>zurück</a>";

 $db = null;
?>