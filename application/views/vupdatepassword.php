
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form id="formupdatepassword" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="USERNAME" class="col-sm-2 control-label">USERNAME :</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="USERNAME" id="USERNAME" value="<?php echo $this->session->userdata('nama_user'); ?>" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PASSLAMA" class="col-sm-2 control-label">PASSWORD LAMA :</label>
                            <div class="col-sm-3">
                                <input type="password" class="form-control" name="PASSLAMA" id="PASSLAMA">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PASSBARU" class="col-sm-2 control-label">PASSWORD BARU :</label>
                            <div class="col-sm-3">
                                <input type="password" class="form-control" name="PASSBARU" id="PASSBARU">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="KONFPASS" class="col-sm-2 control-label">KONFIRMASI PASSWORD :</label>
                            <div class="col-sm-3">
                                <input type="password" class="form-control" name="KONFPASS" id="KONFPASS">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-primary btn-sm" id="button_change" onclick="changepass()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Harap Tunggu"><i class="fa fa-lock fa-fw"></i> Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="notifikasi" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5><i id="font" class="fa"></i> <div style="display:inline" id="status"></div></h5>
                </div>
                <div class="modal-body">
                    <p id="teks"></p>
                </div>
                <div class="modal-footer">
                    <button id="button_close" type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
function changepass() {
    $('#notifikasi').removeClass('modal-danger');
    $('#notifikasi').removeClass ('modal-success');
    $('#font').removeClass('fa-warning fa-fw');
    $('#font').removeClass('fa-check fa-fw');
    $('#button_close').removeClass('btn-danger');
    $('#button_close').removeClass ('btn-success');
    var USERNAME=$('#USERNAME').val();
    var PASSLAMA=$('#PASSLAMA').val();
    var PASSBARU=$('#PASSBARU').val();
    var KONFPASS=$('#KONFPASS').val();
    $('#formupdatepassword').ajaxForm({
        url: "<?php echo base_url('home/proses_update_password'); ?>",
        type: "POST",
        data:{"USERNAME":USERNAME, "PASSLAMA":PASSLAMA, "PASSBARU":PASSBARU, "KONFPASS":KONFPASS},
        beforeSubmit: function() {
            $('#button_change').attr('disabled', 'disabled');
            $('#button_change').button('loading');
        },
        success: function(msg) {
            var msg=$.parseJSON(msg);
            if (msg.status=='Sukses') {
                $('#notifikasi').modal('show');
                $('#notifikasi').addClass('modal-success');
                $('#font').addClass('fa-check fa-fw');
                $('#button_close').addClass('btn-success');
                $('#status').html(msg.status);
                $('#teks').html(msg.pesan);
                $('#button_change').removeAttr('disabled');
                $('#button_change').button('reset');
                $('#PASSLAMA').val('');
                $('#PASSBARU').val('');
                $('#KONFPASS').val('');
            }
            else if(msg.status=='Gagal') {
                $('#notifikasi').modal('show');
                $('#notifikasi').addClass('modal-danger');
                $('#font').addClass('fa-warning fa-fw');
                $('#button_close').addClass('btn-danger');
                $('#status').html(msg.status);
                $('#teks').html(msg.pesan); 
                $('#button_change').removeAttr('disabled'); 
                $('#button_change').button('reset');
            } 
        },
    });
}
</script>