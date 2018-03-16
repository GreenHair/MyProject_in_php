<?php
require("datenbank.php");
$result = $db->query("select * from laden");
$laden = $result->fetchAll();
$result = $db->query("select * from familienmitglied");
$person = $result->fetchAll();
$result = $db->query("select * from produktgruppe");
$kategorieen = $result->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Eintragen</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <Header>Eintragen</Header>
    
    <form action="auswertung.php" method="POST">
        
        
    <table>
        <tr><td><?php print "<a href='".$_SERVER["HTTP_REFERER"]."'>zurück</a>"; ?></td>
        <td><input type="reset"></td><td><input type="submit"></td></tr>
        <tr><th>Datum</th><th>Laden</th><th>Person</th><th>Einmalig</th></tr>
        <tr><td><input type="date" name="datum"></td>
        <td>
            <select name="laden">
                <?php
                    foreach($laden as $shop)
                    {
                        print "<option value='".$shop["ID"]."'>".$shop['name']."</option>";
                    }
                ?>
            </select>
        </td>
        <td>
            <select name="person">
                    <?php
                        foreach($person as $wer)
                        {
                            print "<option value='".$wer['ID']."'>".$wer["vorname"]."</option>";
                        }
                    ?>
            </select>
        </td>
        <td><input type="checkbox" name="einmal" value="1" checked></td></tr>
        <tr><th>Bezeichnung</th><th>Preis</th><th>Kategorie</th></tr>
        <?php
            for($i = 0; $i < 30; $i++)
            {
                print "<tr><td><input type='text' name='bezeichnung[]'></td>
                <td><input type='text' name='preis[]'></td>
                <td><select name='kat[]'>";
                foreach($kategorieen as $cat)
                {
                    print "<option value='".$cat['ID']."'>".$cat['bezeichnung']."</option>";
                }
                print "</select></td></tr>";
            }
        ?>
    </table>
    </form>
</body>
</html>
<?php $db = null; ?>