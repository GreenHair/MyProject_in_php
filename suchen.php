<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/af-2.3.0/b-1.5.2/b-html5-1.5.2/kt-2.4.0/r-2.2.2/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="css\style.css" /> -->
    
    <title>Suchen</title>
    <?php 
        require_once("datenbank.php"); 
        $laden = GetLaden($db);
        $person = GetFamilie($db);
        $kategorieen = GetKategorieen($db);
    ?>
</head>
<body>
    <div class="display-4 text-center mt-5">
        <h1>Haushalt</h1>
        <h3>Suchen</h3>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a class='navbar-brand' href="index.php">Diese Woche</a>
        <a class='navbar-brand' href='index.php?Periode=LetzteWoche'>Letzte Woche</a>
        <a class='navbar-brand' href='index.php?Periode=DiesenMonat'>Diesen Monat</a>
        <a class='navbar-brand' href='index.php?Periode=LetztenMonat'>Letzen Monat</a>
        <a class='navbar-brand' href="index.php?einkommen">Einkommen</a>
        <a class='navbar-brand' href="index.php?eintragen">Eintragen</a>
        <a class='navbar-brand' href="index.php?logout">Logout</a>
    </div>
    </nav>
    <div class="card mx-auto mt-2" style="width:80%">
    <div class="container">
    <form action="" method="POST">
        <div class="form-row">
            <div class="form-group col-md-3">
                <Label for="bez">Bezeichnung</Label>
                <input class="form-control" type="text" name="bez">
            </div>
            <div class="form-group col-md-3">
                <label for="preis">Preis</label>
                <input class="form-control" type="number" name="preis">
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio1" name="rPreis" value=0 class="custom-control-input" checked>
                    <label class="custom-control-label" for="customRadio1">Gleich</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio2" name="rPreis" value=1 class="custom-control-input">
                    <label class="custom-control-label" for="customRadio2">Höher</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio3" name="rPreis" value=2 class="custom-control-input">
                    <label class="custom-control-label" for="customRadio3">Niedriger</label>
                </div>
                
            </div>
            <div class="form-group col-md-3">
                <label for="date">Datum</label>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio4" name="rDate" value='am' class="custom-control-input" checked>
                    <label class="custom-control-label" for="customRadio4">Am</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio5" name="rDate" value='vor' class="custom-control-input">
                    <label class="custom-control-label" for="customRadio5">Vor</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio6" name="rDate" value='nach' class="custom-control-input">
                    <label class="custom-control-label" for="customRadio6">Nach</label>
                </div>
                <input class="form-control date" type="text" name="dat1">
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio7" name="rDate" value='zwischen' class="custom-control-input">
                    <label class="custom-control-label" for="customRadio7">Zwischen</label>
                </div>
                <input class="form-control date" type="text" name="dat2">    
            </div>
            <div class="form-group col-md-3">
                <label for="kategorie">Kategorie</label>
                <select class="form-control" name="kategorie">
                    <option value=0>Auswählen</option>
                        <?php
                            foreach($kategorieen as $cat)
                            {
                                print "<option value='".$cat['ID']."'>".$cat['bezeichnung']."</option>";
                            }
                        ?>
                </select>
                <label for="laden">Laden</label>
                <select class="form-control" name="laden">
                    <option value=0>Auswählen</option>
                        <?php
                            foreach($laden as $shop)
                            {
                                print "<option value='".$shop["ID"]."'>".$shop['name']."</option>";
                            }
                        ?>
                </select>
                <label for="rEin">Einmalig</label>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio8" name="rEin" value='beides' class="custom-control-input" checked>
                    <label class="custom-control-label" for="customRadio8">Beides</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio9" name="rEin" value='einmalig' class="custom-control-input">
                    <label class="custom-control-label" for="customRadio9">Einmalig</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio10" name="rEin" value='feste_ausgaben' class="custom-control-input">
                    <label class="custom-control-label" for="customRadio10">Feste Ausgaben</label>
                </div>
                
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-9">
                <input type="reset" style="margin: 10px">
            </div>                  
            <div class="col-md-3">
                <button class="btn-primary" style="width:100%" type="submit">Suchen</button>    
            </div>                    
        </div>              
    </form>
    </div>
    </div>
    <div class="container-fluid" id="suchergebnis">
        <hr>
        <?php
            if(isset($_REQUEST["bez"]))
            {
                if(!empty($_REQUEST["bez"]) || !empty($_REQUEST["preis"]) || !empty($_REQUEST["dat1"]) || $_REQUEST["kategorie"] != 0 || $_REQUEST["laden"] != 0)
                {
                    $hatVorgaenger = false;
                    $parameters = array();
                    $sql = "select rechnung.datum, ausgaben.bezeichnung, ausgaben.betrag, laden.name, produktgruppe.bezeichnung as kat from ausgaben
                        join rechnung on ausgaben.rechnungsnr = rechnung.id
                        join laden on rechnung.laden = laden.id
                        join produktgruppe on produktgruppe.id = ausgaben.prod_gr
                        where ";
                        if(!empty($_REQUEST["bez"]))
                        {
                            $sql .= "ausgaben.bezeichnung LIKE ?";
                            $parameters[] = "%".$_REQUEST["bez"]."%";
                            $hatVorgaenger = true;
                        }
                        if(!empty($_REQUEST["preis"]))
                        {
                            if($hatVorgaenger){$sql .= " and ";}
                            switch($_REQUEST["rPreis"])
                            {
                                case 0: $sql .= "ausgaben.betrag = ?";break;
                                case 1: $sql .= "ausgaben.betrag <= ?";break;
                                case 2: $sql .= "ausgaben.betrag >= ?";break;
                            }
                            $parameters[] = $_REQUEST["preis"];
                            $hatVorgaenger = true;
                        }
                        if(!empty($_REQUEST["dat1"]))
                        {
                            if($hatVorgaenger){$sql .= " and ";}
                            switch($_REQUEST["rDate"])
                            {
                                case "am": $sql .= "rechnung.datum = '".$_REQUEST["dat1"]."'";break;
                                case "vor": $sql .= "rechnung.datum < '".$_REQUEST["dat1"]."'";break;
                                case "nach": $sql .= "rechnung.datum > '".$_REQUEST["dat1"]."'";break;
                                case "zwischen": $sql .= "rechnung.datum between '".$_REQUEST["dat1"]."' and '".$_REQUEST["dat2"]."'";break;
                            }
                            $hatVorgaenger = true;
                        }
                        if($_REQUEST["kategorie"] != 0)
                        {
                            if($hatVorgaenger){$sql .= " and ";}
                            $sql .= "ausgaben.prod_gr = ".$_REQUEST["kategorie"];
                            $hatVorgaenger = true;
                        }
                        if($_REQUEST["laden"] != 0)
                        {
                            if($hatVorgaenger){$sql .= " and ";}
                            $sql .= "rechnung.laden = ".$_REQUEST["laden"];
                            $hatVorgaenger = true;
                        }
                        if($_REQUEST["rEin"] != 'beides')
                        {
                            if($hatVorgaenger){$sql .= " and ";}
                            if($_REQUEST["rEin"] == 'einmalig')
                            {
                                $sql .= "rechnung.einmalig = 1";
                            }
                            else
                            {
                                $sql .= "rechnung.einmalig = 0";
                            }
                        }
                        // echo $sql."<br>";
                        $stmt = $db->prepare($sql);
                        $stmt->execute($parameters);
                        $tabelle = $stmt->fetchAll();
                        // ausgabe der Resultaten
                        print "<div style='padding:10px'><table id='tableResult' class='display'>"; 
                        print "<thead>
                        <tr><th>Datum</th><th>Bezeichnung</th><th>Betrag</th><th>Laden</th><th>Kategorie</th></tr>
                        </thead>
                        <tbody>";
                        foreach($tabelle as $zeile)
                        {
                            print "<tr><td>".date("d.m.y" , strtotime($zeile['datum']))."</td>
                            <td>".$zeile['bezeichnung']."</td>
                            <td>".number_format($zeile['betrag'],2)."€</td>
                            <td>".$zeile['name']."</td>
                            <td>".$zeile['kat']."</td></tr>";
                        }
                        echo "</tbody><tfoot><tr><th colspan='2'></th><th colspan='3'></th></tr></tfoot></table></div>";
                }
            }
        ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/af-2.3.0/b-1.5.2/b-html5-1.5.2/kt-2.4.0/r-2.2.2/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#tableResult').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\€,]/g, '').replace(",",".")*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
        
                    // Total over all pages
                    total = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                    // Total over this page
                    pageTotal = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                    // Update footer
                    $( api.column( 2 ).footer() ).html(
                        new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(pageTotal) +' ( '+ new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(total) +' total)'
                    );
                }
            });
        });

        $('.date').datepicker({
            "todayHighlight": true,
            "autoclose": true,
            "format": "yyyy-mm-dd"
                
        });
    </script>
</body>
</html>
<?php $db = null; ?>