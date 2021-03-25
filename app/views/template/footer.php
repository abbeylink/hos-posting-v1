<?php
$data = functions::get_company_setting();
?>
</div>
<div id="footers" class=""> <p>Copyright © 2019. <?= ucwords(strtolower($data['comp_name'])); ?>. </p></div>

<div id="poweredBy">Powered by    <a href="<?= $data['site']; ?>" target="_blank">
        <?= $data['designer']; ?>
    </a>
</div>

<div id="simplemodal_loader" class="mymodal">
    <div class="mymodal_content"style="width: 0px">
        <div class="load_text">
            <img src="<?= asset ?>images/loading.gif" width="50px" height="50px"/>
            <h2></h2>
        </div>

    </div></div>


<!-- Modal -->
<div class="modal fade" id="Msg_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="msg"></div>

                    <!--                    <button type="button" class="btn btn-success go_preview hidden" id="">OK</button>-->
                </div>
            </div>
        </div>
    </div>
</div>
<a href="#" class="msg_show hidden" data-toggle="modal" data-target="#Msg_Modal" > </a>


<script  src="<?= asset; ?>js/jquery-3.4.1.min.js"></script>
<script  src="<?= asset; ?>js/bootstrap.js"></script>
<script  src="<?= asset; ?>js/mdb.js"></script>
<script  src="<?= asset; ?>js/pooper.min.js"></script>
<script  src="<?= asset; ?>js/select2.full.min.js"></script>
<script  src="<?= asset; ?>js/jquery.cookie.js"></script>
<script  src="<?= asset; ?>js/all.js"></script>
<script  src="<?= asset; ?>js/jquery.inputmask.bundle.js"></script>
<script  src="<?= asset ?>js/jquery.smartWizard.min.js"></script>
<script  src="<?= asset; ?>js/step.js"></script>
<script  src="<?= asset; ?>js/custom_jquery.js"></script>
<script  src="<?= asset; ?>js/zoomerang.js"></script>

<script  src="<?= asset; ?>js/Chart.min.js"></script>
<script  src="<?= asset; ?>js/moment.min.js"></script>
<script  src="<?= asset; ?>js/fingerprint.js"></script>

<script  src="<?= asset; ?>js/bootstrap3-typeahead.min.js"></script>
<script  src="<?= asset; ?>js/moment.min.js"></script>
<script  src="<?= asset; ?>js/toastr.min.js"></script>

<script  src="<?= asset; ?>js/jquery.dropdown.js"></script>
<script  src="<?= asset; ?>js/jquery-ui-1.12.1.custom.min.js"></script>
<script  src="<?= asset; ?>js/jquery.datetimepicker.js"></script>
</body>

</html>
