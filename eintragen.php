<?php
require_once("datenbank.php");
/* $result = $db->query("select * from laden");
$laden = $result->fetchAll();
$result = $db->query("select * from familienmitglied");
$person = $result->fetchAll();
$result = $db->query("select * from produktgruppe");
$kategorieen = $result->fetchAll(); */
$laden = GetLaden($db);
$person = GetFamilie($db);
$kategorieen = GetKategorieen($db);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Eintragen</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"/>
    <!-- Bootstrap Date-Picker Plugin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <!-- <link rel="stylesheet" href="css/style.css" /> -->
</head>
<body class="pb-5">
<div class="display-4 text-center mt-5">
    <h1>Haushalt</h1>
    <h3>Eintragen</h3>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class='navbar-brand' href="index.php">Diese Woche</a>
            </li>
            <li class="nav-item active"><a class='navbar-brand' href='index.php?Periode=LetzteWoche'>Letzte Woche</a></li>
            <li class="nav-item active"><a class='navbar-brand' href='index.php?Periode=DiesenMonat'>Diesen Monat</a></li>
            <li class="nav-item active"><a class='navbar-brand' href='index.php?Periode=LetztenMonat'>Letzen Monat</a></li>
            <li class="nav-item active"><a class='navbar-brand' href="index.php?einkommen">Einkommen</a></li>
            
            <li class="nav-item active dropdown">
                <a class="nav-link navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Eintragen
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class='dropdown-item' href="#einkommen">Einkommen</a>
                    <a class='dropdown-item' href="#laden">Laden</a>
                    <a class='dropdown-item' href="#kategorie">Kategorie</a>
                
                </div>
            </li>

            <li class="nav-item active"><a class='navbar-brand' href="index.php?suchen">Suchen</a></li>
            <li class="nav-item active"><a class='navbar-brand' href="index.php?logout">Logout</a></li>

            
            </ul>
            
        </div>
    </nav>
    <br>
    <fieldset class="border rounded container-fluid" style="width:90%">
    <legend class="w-auto">Neue Rechnung</legend>
    <form id="neueRechnung">
        <div class="form-row">    
            <div class="col-10">
                <button class="btn-secondary" type="reset">Zurücksetzen</button>
            </div>
            <div class="col-2">   
                <button class="btn-primary" type="submit" style='width:100%'>Senden</button>
            </div>
        </div>
        <div class="form-row">
            <div class="col-auto">
                <label class="col-form-label" for="datum">Datum</label>
                <input type="text" id="datepicker" class="form-control mr-sm-2 datepicker pb-2" name="datum" value="Datum auswählen">
            </div>
            <div class="col-3">
                <label class="col-form-label" for="laden">Laden</label>
                <select name="laden" class="custom-select mr-sm-2">
                    <?php
                    foreach ($laden as $shop) {
                        print "<option value='" . $shop["ID"] . "'>" . $shop['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="col-form-label" for="person">Person</label>
                <select name="person" class="custom-select mr-sm-2">
                    <?php
                    foreach ($person as $wer) {
                        print "<option value='" . $wer['ID'] . "'>" . $wer["vorname"] . "</option>";
                    }
                    ?>
                </select>
            </div>        
            <div class="col-auto">
                <div class="custom-control custom-checkbox mt-4 pt-3">
                    <input type="checkbox" name="einmal" value="1" checked class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Einmalig</label>
                </div>
            </div>   
        </div>
        
        <div class="form-row">
            <div class="col-6">
                <label>Bezeichnung</label>
            </div>
            <div class="col-3">
                <label>Preis</label>
            </div>
            <div class="col-3">
                <label>Kategorie</label>
            </div>
        </div>
        <?php
        for ($i = 0; $i < 30; $i++) {
            print "<div class='form-row'><div class='col-6'><input type='text' class='form-control' name='bezeichnung[]'></div>
                <div class='col-3'>
                <div class='input-group'>
                <div class='input-group-prepend'><div class='input-group-text'>€</div></div><input type='number' step='0.01' class='form-control' name='preis[]'></div></div>
                <div class='col-3'><select class='custom-select mr-sm-2' name='kat[]'>";
            foreach ($kategorieen as $cat) {
                print "<option value='" . $cat['ID'] . "'>" . $cat['bezeichnung'] . "</option>";
            }
            print "</select></div></div>";
        }
        ?>
    </form>
    </fieldset>
   
 <fieldset class="border rounded container-fluid pb-2" style="width:90%">
    <legend class="w-auto">Einkommen</legend>
    <form action="eintragen_einkommen.php" method="POST">
        <div class="form-row" id="einkommen">            
            <div class="col-2">
                <label>Datum</label>
                <input type="text" id="datepicker" class="form-control datepicker pb-2" name="datum" value="Datum auswählen">
            </div>
            <div class="col-3">
                <label>Bezeichnung</label>
                <input type='text' name='bezeichnung' class='form-control'>
            </div>
            <div class="col-3">
            <label>Person</label>
                <select name="person" class='form-control'>
                        <?php
                        foreach ($person as $wer) {
                            print "<option value='" . $wer['ID'] . "'>" . $wer["vorname"] . "</option>";
                        }
                        ?>
                </select>
            </div>
            <div class="col-2">
                <label>Betrag</label>
                <input type='text' name='betrag' class='form-control'>
            </div>
            <div class="col-2 pt-2">
                <button type="submit" class="btn-primary mt-4 pt-1 pb-1">Senden</button>
            </div>
        </div>
    </form>
 </fieldset>

 <fieldset class="border rounded container-fluid pb-2" style="width:90%">
    <legend class="w-auto">Laden</legend>
    <form action="eintragen_einkommen.php" method="POST">
        <label>Name</label>
        <div class="form-row" id="laden">                    
            <div class="col-5">                
                <input type='text' name='laden_name' class="form-control">
            </div>            
            <div class="col-2 pt-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="online" value="1" class="custom-control-input" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Online</label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit" class="btn-primary pt-1 pb-1">Senden</button>
            </div>
        </div>
    </form>
    </fieldset>
 

 <fieldset class="border rounded container-fluid pb-2" style="width:90%">
    <legend class="w-auto">Kategorie</legend>
    <form action="eintragen_einkommen.php" method="POST">
    <label>Bezeichnung</label>
        <div class="form-row" id="laden">            
            <div class="col-5">
                
                <input type='text' name='produktgruppe' class="form-control">
            </div>            
            <div class="col-2 pt-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="essen" value="1" class="custom-control-input" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">Essen</label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit" class="btn-primary pt-1 pb-1">Senden</button>
            </div>
        </div>
    </form>
 </fieldset>
 <?php
    if (isset($_REQUEST["result"])) {
        if ($_REQUEST["result"] > 0) {
            echo "<script>alert('Daten erfolgreich eingetragen');</script>";
            unset($_REQUEST["result"]);
        } else {
            echo "<script>alert('Da hat etwas nicht geklappt...');</script>";
        }
    }
?>

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    
    <script>

        $(document).ready(function(){
            
            $('.datepicker').datepicker({
                "todayHighlight": true,
                "autoclose": true,
                "format": "dd.mm.yyyy"
                
            });
            let options = { year: 'numeric', month: '2-digit', day: '2-digit' };
            let date = new Intl.DateTimeFormat('de-DE', options).format;
            $('.datepicker').val(date(new Date().now));

            $("#neueRechnung").submit(function(evt){
                evt.preventDefault();
                var formData = $("#neueRechnung").serialize();
                console.log(formData);
                $.ajax({
                    url: "auswertung.php",
                    method: "post",
                    cache: "false",
                    data: formData
                }).done(function(result){
                    console.log("result:",result);
                    if(result > 0){
                        alert('Daten erfolgreich eingetragen');
                        $("#neueRechnung")[0].reset();
                        $('.datepicker').val(date(new Date().now));
                        $('.datepicker').first().focus();
                    }else{
                        alert('Da hat etwas nicht geklappt...');
                    }
                })
            })
        });
    </script>
</body>
</html>
<?php $db = null; ?>