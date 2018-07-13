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
    <meta charset="utf-8" />
    <title>Eintragen</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body style="padding-left:10px">
    <Header>Haushalt</Header>
    <h3>Eintragen</h3>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class='navbar-brand' href='index.php'>zurück</a>
            <a class='navbar-brand' href="#einkommen">Einkommen</a>
            <a class='navbar-brand' href="#laden">Laden</a>
            <a class='navbar-brand' href="#kategorie">Kategorie</a>
        </div>
    </nav>
    <br>
    <fieldset class="border" style="padding:20px">
    <legend>Neue Rechnung</legend>
    <form action="auswertung.php" method="POST">
        <div class="form-row">    
            <div class="col-10">
                <button class="btn-secondary" type="reset">Zurücksetzen</button>
            </div>
            <div class="col-2">   
                <button class="btn-primary" type="submit" style='width:80%'>Senden</button>
            </div>
        </div>
        <div class="form-row">
            <div class="col-3">
                <label for="datum">Datum</label>
         <!--       <div class="input-group date" data-provide="datepicker">
                    <input type="text" id="datepicker" class="form-control" name="datum" value="Datum auswählen">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                
                <input type="date" name="datum">        -->
                <input type="text" id="datepicker" class="form-control datepicker" name="datum" value="Datum auswählen">
            </div>
            <div class="col-3">
                <label class="col-form-label" for="laden">Laden</label>
                <select name="laden" class="custom-select mr-sm-2">
                    <?php
                        foreach($laden as $shop)
                        {
                            print "<option value='".$shop["ID"]."'>".$shop['name']."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="col-form-label" for="person">Person</label>
                <select name="person" class="custom-select mr-sm-2">
                    <?php
                        foreach($person as $wer)
                        {
                            print "<option value='".$wer['ID']."'>".$wer["vorname"]."</option>";
                        }
                    ?>
                </select>
            </div>        
            <div class="col-3">
                <div class="custom-control custom-checkbox" style='margin-top:35px'>
                    <input type="checkbox" name="einmal" value="1" checked class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Einmalig</label>
                </div>
            </div>   
        </div>
        
        <div class="form-row">
            <div class="col-6">
                <label>Bezeichnung</lablel>
            </div>
            <div class="col-3">
                <label>Preis</label>
            </div>
            <div class="col-3">
                <label>Kategorie</label>
            </div>
        </div>
        <?php
            for($i = 0; $i < 30; $i++)
            {
                print "<div class='form-row'><div class='col-6'><input type='text' class='form-control' name='bezeichnung[]'></div>
                <div class='col-3'><input type='text' class='form-control' name='preis[]'></div>
                <div class='col-3'><select class='custom-select mr-sm-2' name='kat[]'>";
                foreach($kategorieen as $cat)
                {
                    print "<option value='".$cat['ID']."'>".$cat['bezeichnung']."</option>";
                }
                print "</select></div></div>";
            }
        ?>
    </form>
    </fieldset>
   
 <fieldset>
    <legend>Einkommen</legend>
    <form action="eintragen_einkommen.php" method="POST">
        <div class="form-row" id="einkommen">            
            <div class="col-2">
                <label>Datum</label>
                <input type="text" id="datepicker" class="form-control datepicker" name="datum" value="Datum auswählen">
            </div>
            <div class="col-3">
                <label>Bezeichnung</label>
                <input type='text' name='bezeichnung' class='form-control'>
            </div>
            <div class="col-3">
            <label>Person</label>
                <select name="person" class='form-control'>
                        <?php
                            foreach($person as $wer)
                            {
                                print "<option value='".$wer['ID']."'>".$wer["vorname"]."</option>";
                            }
                        ?>
                </select>
            </div>
            <div class="col-2">
                <label>Betrag</label>
                <input type='text' name='betrag' class='form-control'>
            </div>
            <div class="col-2">
                <button type="submit" class="btn-primary" style='margin-top:35px'>Senden</button>
            </div>
        </div>
    </form>
 </fieldset>

 <fieldset  style="padding-left:10px">
    <legend>Laden</legend>
    <form action="eintragen_einkommen.php" method="POST">
        <label>Name</label>
        <div class="form-row" id="laden">                    
            <div class="col-5">                
                <input type='text' name='laden_name' class="form-control">
            </div>            
            <div class="col-1">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="online" value="1" class="custom-control-input" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Online</label>
                </div>
            </div>
            <div class="col-6">
                <button type="submit" class="btn-primary">Senden</button>
            </div>
        </div>
    </form>
    </fieldset>
 

 <fieldset>
    <legend>Kategorie</legend>
    <form action="eintragen_einkommen.php" method="POST">
    <label>Bezeichnung</label>
        <div class="form-row" id="laden">            
            <div class="col-5">
                
                <input type='text' name='produktgruppe' class="form-control">
            </div>            
            <div class="col-1">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="essen" value="1" class="custom-control-input" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">Essen</label>
                </div>
            </div>
            <div class="col-6">
                <button type="submit" class="btn-primary">Senden</button>
            </div>
        </div>
    </form>
 </fieldset>

    
    <script>

        $(document).ready(function(){
            $(".eintragen").DataTable({
                "paging": false,
                "orderable": false,
                "searching": false,
                "info": false,
                "columns": [
                { "width": "25%" },
                { "width": "25%" },
                { "width": "25%" },
                { "width": "25%" }
                ]
            });

            

            $('.datepicker').datepicker({
                "todayHighlight": true,
                "autoclose": true,
                "format": "yyyy-mm-dd"
                
            });
            var options = { year: 'numeric', month: '2-digit', day: '2-digit' };
            var date = new Intl.DateTimeFormat('de-DE', options).format;
            $('.datepicker').val(date(new Date().now));
        });
    </script>
    <?php
    if(isset($_REQUEST["result"])){
        if($_REQUEST["result"] > 0){
            echo "<script>alert('Daten erfolgreich eingetragen');</script>";
            unset($_REQUEST["result"]);
        }
        else{
            echo "<script>alert('Da hat etwas nicht geklappt...');</script>";
        }
    }
    ?>
</body>
</html>
<?php $db = null; ?>