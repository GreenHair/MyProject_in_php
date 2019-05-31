<div class="modal fade" id="modal_update_rechnung" tabindex="-1" role="dialog" aria-labelledby="modal_update_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_update_title">Rechnung Bearbeiten</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="auswertung.php">
          <input type="hidden" name="update_rechnung" value="1">
          <input type="hidden" name="r_id" id="modal_r_id" value="0">
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-9">
              <label class="col-form-label" for="laden">Laden</label>
                <select name="laden" class="custom-select mr-sm-2" id="update_laden">
                    <?php
                    $laden = GetLaden($db);
                    foreach ($laden as $shop) {
                      print "<option value='" . $shop["ID"] . "'>" . $shop['name'] . "</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group col-md-3">
              <label class="col-form-label" for="person">Person</label>
                <select name="person" class="custom-select mr-sm-2" id="update_person">
                    <?php
                    $person = GetFamilie($db);
                    foreach ($person as $wer) {
                      print "<option value='" . $wer['ID'] . "'>" . $wer["vorname"] . "</option>";
                    }
                    ?>
                </select>
              </div>
           </div>
           <div class="form-row">
            <div class="form-group col-md-6">
              <label class="col-form-label" for="update_datum">Datum</label>
              <input type="text" id="update_datum" class="form-control datepicker" name="update_datum" value="Datum auswählen">        
             </div>
             <div class="custom-control custom-checkbox" style='margin-top:35px'>
              <input type="checkbox" name="einmal" value="1" class="custom-control-input" id="update_einmalig">
              <label class="custom-control-label" for="update_einmalig">Einmalig</label>
            </div>
           </div>
           <p>
            
            <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              Artikel hinzufügen
            </button>
          </p>
          <div class="collapse" id="collapseExample">
          <div class="form-row">
              <div class="form-group col-md-9">
                <label for="extra_bezeichnung">Bezeichnung</label>
                <input type="text" class="form-control" name = "extra_bezeichnung" id="extra_bezeichnung" placeholder="">
                <label class="col-form-label" for="kategorie">Kategorie</label>
                <select name="extra_kategorie" class="custom-select mr-sm-2" id="extra_kategorie">
                    <?php
                    $kategorieen = GetKategorieen($db);
                    foreach ($kategorieen as $cat) {
                      print "<option value='" . $cat['ID'] . "'>" . $cat['bezeichnung'] . "</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="extra_betrag">Betrag</label>
                <div class='input-group'>
                  <div class='input-group-prepend'>
                    <div class='input-group-text'>€</div>
                  </div>
                  <input type="number" step="0.01" class="form-control" name="extra_betrag" id="extra_betrag" placeholder="">
                </div>
              </div>
            </div>
          </div>           
          </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>