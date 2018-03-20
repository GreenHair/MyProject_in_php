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

?>