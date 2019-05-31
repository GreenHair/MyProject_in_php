

  <!-- Modal -->
  <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="modal_update_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_update_title">Eintrag Bearbeiten</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="auswertung.php">
          <input type="hidden" name="update_ausgabe" value="1">
          <input type="hidden" name="a_id" id="modal_a_id" value="0">
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-9">
                <label for="modal_bezeichnung">Bezeichnung</label>
                <input type="text" class="form-control" name = "bezeichnung" id="modal_bezeichnung" placeholder="">
                <label class="col-form-label" for="kategorie">Kategorie</label>
                <select name="kategorie" class="custom-select mr-sm-2" id="update_kategorie">
                    <?php
                    $kategorieen = GetKategorieen($db);
                    foreach ($kategorieen as $cat) {
                      print "<option value='" . $cat['ID'] . "'>" . $cat['bezeichnung'] . "</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="modal_betrag">Betrag</label>
                <div class='input-group'>
                  <div class='input-group-prepend'>
                    <div class='input-group-text'>€</div>
                  </div>
                  <input type="number" step="0.01" class="form-control" name="betrag" id="modal_betrag" placeholder="">
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
