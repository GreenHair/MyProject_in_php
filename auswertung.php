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
    $datum = date("Y-m-d",strtotime($_REQUEST['datum']));
    $befehl =  "insert into rechnung(datum,laden,person,einmalig) values ('".$datum."',".$_REQUEST['laden'].",".$_REQUEST["person"].",".$einmal.");";
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

    if($result1 && $result2){
        insertResult(1);
    }
    else{
        insertResult(0);
    }

   /* print $result1." rows affected<br>";
    print $result2." rows affected<br>";*/
}else if(isset($_REQUEST["update_ausgabe"])){
    $a_id = $_REQUEST["a_id"];
    $bezeichnung = $_REQUEST["bezeichnung"];
    $preis = str_ireplace('€','',$_REQUEST["betrag"]); 
    $preis = str_ireplace(',','.',$preis);    
    $sql = "UPDATE ausgaben SET bezeichnung = ?, betrag = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $updateResult = $stmt->execute(array($bezeichnung,$preis,$a_id));
    if(updateResult){
        reloadPage();
    }
    else{
        reloadPageWithError();
    }
}
else
{
    print "Keine Daten zum Eintragen<br>";
}

//print "<a href='".$_SERVER["HTTP_REFERER"]."'>zurück</a><br>";
//print "<a href='index.php'>Übersicht</a>";

 $db = null;

function insertResult($intResult)
{
    echo "<script>
        location.href = './eintragen.php?result=$intResult';
    </script>";
}

function reloadPage()
{
    echo "<script>
        location.href = '".$_SERVER["HTTP_REFERER"]."'
    </script>";
}

function reloadPageWithError()
{
    echo "<script>
        alert('Das hat nicht geklappt...');
        location.href = '".$_SERVER["HTTP_REFERER"]."'
    </script>";
}

?>