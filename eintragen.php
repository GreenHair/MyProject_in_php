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
    <nav>
        <a href='index.php'><button>zurück</button></a>
        <a href="#einkommen"><button >Einkommen</button></a>
        <a href="#laden"><button >Laden</button></a>
        <a href="#kategorie"><button >Kategorie</button></a>
    </nav>
    <br>
    <form action="auswertung.php" method="POST">
    <table>
        <tr><!-- <td><?php print "<a href='index.php'>zurück</a>"; ?></td> -->
        <td><input type="reset"></td><td></td><td></td><td><input type="submit"></td></tr>
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
    <form action="eintragen_einkommen.php" method="POST">
        <table id="einkommen">
            <caption>Einkommen</caption>
            <tr><th>Datum</th><th>Bezeichnung</th><th>Person</th><th>Betrag</th></tr>
            <tr><td><input type="date" name="datum"></td>
            <td><input type='text' name='bezeichnung'></td>
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
            <td><input type='text' name='betrag'></td>
            </tr>
        </table>
        <input type="submit">
    </form>

    <form action="eintragen_einkommen.php" method="POST">
        <table id="laden">
            <caption>Laden</caption>
            <tr><th>Name</th><th>Online</th></tr>
            <td><input type='text' name='laden_name'></td>
            <td><input type="checkbox" name="online" value="1"></td></tr>
        </table>
        <input type="submit">
    </form>

    <form action="eintragen_einkommen.php" method="POST">
        <table id="kategorie">
            <caption>Kategorie</caption>
            <tr><th>Bezeichnung</th><th>Lebensmittel</th></tr>
            <td><input type='text' name='produktgruppe'></td>
            <td><input type="checkbox" name="essen" value="1"></td></tr>
        </table>
        <input type="submit">
    </form>
</body>
</html>
<?php $db = null; ?>