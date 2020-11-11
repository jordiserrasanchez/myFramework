            <?php if ( $this->showModal ) { ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle"><?php echo $this->objecteModalWindow->cardtitle ?? "";?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="modal-body">
                        <?php echo $this->objecteModalWindow->cardtext ?? "";?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cardbutton" data-dismiss="modal"><?php echo $this->objecteModalWindow->cardbutton ?? "";?></button>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>