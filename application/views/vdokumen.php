<?php
$PESAN = $this->session->userdata('PESAN');
?>
<input type="hidden" value="" id="noagendaVALUE">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form id="form_upload" class="form-horizontal" method="POST" enctype="multipart/form-data" >
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> No Tiket  </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="no_tiket" id="no_tiket" value="" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> No BA  </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="noba" id="noba" class="form-control"  >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> No Agenda  </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="noagenda" id="noagenda" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Tanggal Catat  </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="tgl_catat" value="" class="form-control" id="tgl_catat" readonly="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Jenis Transaksi  </label>
                                    <div class="col-sm-7">
                                        <select name="jenis_transaksi" id="jenis_transaksi" class="form-control" maxlength="6">
                                            <option value="">--- Pilih Jenis Transaksi ---</option>
                                            <?php foreach ($rs_jenis_transaksi as $row) { ?>
                                                <option value="<?php echo $row['JENIS_TRANSAKSI']; ?>" ><?php echo strtoupper($row['JENIS_TRANSAKSI']); ?></option>   
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3 control-label"> Perihal  </label>
                                    <div class="col-sm-7">
                                       <input type="text" name="tgl_catat" value="" class="form-control" id="perihal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm" id="bcari" onclick="cari()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Harap Tunggu"><i class="fa fa-search fa-fw"></i> Cari</button>
                        </div>
                        <div class="btn-group">
                            <a class="btn btn-info btn-sm" id="button_refresh" href="<?php echo base_url('home/dokumen'); ?> "><i class="fa fa-refresh fa-fw"></i> Refresh</a>
                        </div>
                        <div class="btn-group">
                            <a class="btn btn-primary btn-sm" id="btambah_new_entry" onclick="modal_tambah()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Harap Tunggu"><i class="fa fa-plus fa-fw"></i> Tambah</a>
                        </div>

                        <div class="btn-group">
                            <a href="<?php echo base_url('home/cetak_excel'); ?> " class="btn btn-primary btn-sm"  ><i class="fa fa-file-excel-o fa-fw"></i> Cetak Excel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">NO_TIKET</th>
                                    <th width="10%">NOAGENDA</th>
                                    <th width="10%">JENIS_TRANSAKSI</th>
                                    <th width="10%">IDPEL</th>
                                    <th width="10%">SUPPORT</th>
                                    <th width="10%">NO_BA</th>
                                    <th width="10%">TGL_CATAT</th>				
                                    <th width="10%">PERIHAL</th>				
                                    <th width="25%">FILE</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
    <div id="modal_upload" class="modal fade bs-example-modal-lg modal-primary" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-lg">
            <form id="form_upload_file" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="m_id_upload" id="m_id_upload" value="" />
                <input type="hidden" name="m_noagenda" id="m_noagenda" value="" />
                <input type="hidden" name="noba" id="m_noba" value=""/>
                <input type="hidden" name="jenis_transaksi" id="m_jenis_transaksi" value=""/>
                <input type="hidden" name="m_no_tiket" id="m_no_tiket" value="" />
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>FORM UPLOAD DOKUMEN</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Unggah Dokumen : </label>
                                    <div class="col-sm-7">
                                        <input type="file" name="nama_file" id="nama_file" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="button_close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-warning" id="button_simpan" onclick="simpan()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Harap Tunggu"><i class="fa fa-save fa-fw"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal tambah baru start -->
    <div id="modal_tambah" class="modal fade  modal-primary" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-lg">
            <form id="form_tambah" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action_input" id="action_input" value="">
                <input type="hidden" name="no_tiket_now" id="no_tiket_now" value="">
                <input type="hidden" name="noagenda_now" id="noagenda_now" value="">
                <input type="hidden" name="idpel_now" id="idpel_now" value="">
                <input type="hidden" name="no_ba_now" id="no_ba_now" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5><div id="judul"></div></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> NO_TIKET </label>
                                            <div class="col-sm-5">
                                                <input type="text" name="no_tiket_new" id="no_tiket_new" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> NOAGENDA </label>
                                            <div class="col-sm-5">
                                                <input type="text" name="noagenda_new" id="noagenda_new" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> IDPEL </label>
                                            <div class="col-sm-5">
                                                <input type="text" name="idpel_new" id="idpel_new" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> PERMINTAAN_DARI </label>
                                            <div class="col-sm-7">
                                                <input type="text" name="permintaan_dari_new" id="permintaan_dari_new" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> Jenis Transaksi  </label>
                                            <div class="col-sm-4">
                                                <select name="jenis_transaksi_new" id="jenis_transaksi_new" class="form-control" maxlength="6">
                                                    <option value="">--- Pilih Jenis Transaksi ---</option>
                                                    <?php foreach ($rs_jenis_transaksi as $row) { ?>
                                                        <option value="<?php echo $row['JENIS_TRANSAKSI']; ?>" ><?php echo strtoupper($row['JENIS_TRANSAKSI']); ?></option>   
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="jenis_transaksi_new_baru" id="jenis_transaksi_new_baru" class="form-control" placehoder="Tambah baru" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> PERIHAL  </label>
                                            <div class="col-sm-7">
                                                <input type="text" name="perihal_new" id="perihal_new" class="form-control"  >
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> NO_BA  </label>
                                            <div class="col-sm-5">
                                                <input type="text" name="no_ba_new" id="no_ba_new" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> NAMA SUPPORT  </label>
                                            <div class="col-sm-5">
                                                <select name="id_user_new" id="id_user_new" class="form-control" maxlength="6">
                                                    <option value="">--- Pilih Nama Support ---</option>
                                                    <?php foreach ($rs_nama_support as $row) { ?>
                                                        <option value="<?php echo $row['ID_USER']; ?>" ><?php echo strtoupper($row['NAMA_USER']); ?></option>   
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> TANGGAL PERMINTAAN  </label>
                                            <div class="col-sm-5">
                                                <input type="text" name="tgl_permintaan_new" value="" class="form-control" id="tgl_permintaan_new" readonly="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> RESOLUTION  </label>
                                            <div class="col-sm-7">
                                                <input type="text" name="resolution_new" id="resolution_new" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"> STATUS  </label>
                                            <div class="col-sm-4">
                                                <select name="status_data_new" id="status_data_new" class="form-control" maxlength="6">
                                                    <option value="AKTIF" >AKTIF</option>
                                                    <option value="RESOLVED">RESOLVED</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="button_close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="reset" class="btn btn-default" >Reset</button>
                    <button class="btn btn-warning" id="button_simpan" onclick="simpan_baru()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Harap Tunggu"><i class="fa fa-save fa-fw"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal tambah baru ENd -->
    <!-- MODAL DELETE -->

    <div id="modal_delete" class="modal fade bs-example-modal-sm modal-danger" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <form id="form_delete" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="no_tiket_del" id="no_tiket_del" value="">
                <input type="hidden" name="noagenda_del" id="noagenda_del" value="">
                <input type="hidden" name="idpel_del" id="idpel_del" value="">
                <input type="hidden" name="no_ba_del" id="no_ba_del" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Apakah yakin untuk menghapus data berikut ?</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> NO_TIKET </label>
                                    <div class="col-sm-5">
                                        <input type="text" name="no_tiket" id="no_tiket_del2" disabled="" class="form-control"  >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="button_close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-warning" id="button_delete" onclick="hapus()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Harap Tunggu"><i class="fa fa-save fa-fw"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="loading_modal">
        <div class="modal-dialog modal-sm" role="document">
            <img src="<?php echo base_url('assets/dist/img/ajax-loader.gif');?>" alt="" />
        </div>
    </div>
    
</div>
<?php
if (isset($PESAN)) {
    ?>
    <div id="notifikasi1" class="modal fade bs-example-modal-sm modal-danger" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5><i id="font" class="fa fa-warning fa-fw"></i> Gagal</h5>
                </div>
                <div class="modal-body">
                    <p><?php echo $PESAN; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
</section>
<script type="text/javascript">
    // set value
    $('#tgl_permintaan_new').datepicker({
        format: 'yyyy/dd/mm',
        autoclose: true
    });
    
    function reset_notification(){
        $('#notifikasi').removeClass('modal-danger');
        $('#notifikasi').removeClass('modal-warning');
        $('#notifikasi').removeClass('modal-success');
        $('#font').removeClass('fa-danger fa-fw');
        $('#font').removeClass('fa-warning fa-fw');
        $('#font').removeClass('fa-check fa-fw');
        $('#button_close').removeClass('btn-danger');
        $('#button_close').removeClass('btn-warning');
        $('#button_close').removeClass('btn-success');
    }
    
    function show_success_notification(status, pesan){
        $('#notifikasi').modal('show');
        $('#notifikasi').addClass('modal-success');
        $('#font').addClass('fa-check fa-fw');
        $('#button_close').addClass('btn-success');
        $('#status').html(status);
        $('#teks').html(pesan);
    }
    function show_warning_notification(status, pesan){
        $('#notifikasi').modal('show');
        $('#notifikasi').addClass('modal-warning');
        $('#font').addClass('fa-warning fa-fw');
        $('#button_close').addClass('btn-warning');
        $('#status').html(status);
        $('#teks').html(pesan);
    }
    function show_failed_notification(status, pesan){
        $('#notifikasi').modal('show');
        $('#notifikasi').addClass('modal-danger');
        $('#font').addClass('fa-danger fa-fw');
        $('#button_close').addClass('btn-danger');
        $('#status').html(status);
        $('#teks').html(pesan);
    }
    
    function modal_tambah() {
        //preventDefault();
        $('#modal_tambah').modal('show');
        $("#action_input").val('TAMBAH');
        $('#judul').html('FORM TAMBAH DATA');
    }

    function modal_edit(noagenda, noba, jenis_transaksi, no_tiket) {

        $.ajax({// menggunakan ajax form
            url: "<?php echo base_url('home/get_edit_value'); ?>",
            type: "POST",
            data: {"noagenda": noagenda, "noba": noba, "no_tiket": no_tiket},
            beforeSend: function () {
                // non removable loading
                $('#loading_modal').modal({
                    backdrop: 'static', keyboard: false
                });
            },
            success: function (output) {
                var output = $.parseJSON(output);
                //alert(JSON.stringify(output));
                $('#loading_modal').modal('hide');

                $("#no_tiket_new").val(output.data.NO_TIKET);
                $("#noagenda_new").val(output.data.NOAGENDA);
                $("#idpel_new").val(output.data.IDPEL);
                $("#permintaan_dari_new").val(output.data.PERMINTAAN_DARI);
                $("#jenis_transaksi_new").val(output.data.JENIS_TRANSAKSI);
                $("#perihal_new").val(output.data.PERIHAL);
                $("#no_ba_new").val(output.data.NO_BA);
                $("#id_user_new").val(output.data.ID_USER);
                $("#tgl_permintaan_new").val(output.data.TGL_PERMINTAAN);
                $("#resolution_new").val(output.data.RESULOTION);
                $("#status_data_new").val(output.data.STATUS);
                $("#action_input").val('EDIT');
                //
                $("#no_tiket_now").val(output.data.NO_TIKET);
                $("#noagenda_now").val(output.data.NOAGENDA);
                $("#idpel_now").val(output.data.IDPEL);
                $("#no_ba_now").val(output.data.NO_BA);
                // 
                $('#judul').html('FORM EDIT DATA');
                $('#modal_tambah').modal('show');
            },
        });
    }

    function modal_delete(noagenda, noba, jenis_transaksi, no_tiket) {

        $.ajax({// menggunakan ajax form
            url: "<?php echo base_url('home/get_edit_value'); ?>",
            type: "POST",
            data: {"noagenda": noagenda, "noba": noba, "no_tiket": no_tiket},
            beforeSend: function () {
            },
            success: function (output) {
                var output = $.parseJSON(output);
                //alert(JSON.stringify(output));

                $("#no_tiket_del").val(output.data.NO_TIKET);
                $("#no_tiket_del2").val(output.data.NO_TIKET);
                $("#noagenda_del").val(output.data.NOAGENDA);
                $("#idpel_del").val(output.data.IDPEL);
                $("#no_ba_del").val(output.data.NO_BA);
                // 
                $('#modal_delete').modal('show');
                $('#modal_delete').addClass('modal-danger');
            },
        });

    }

    function simpan_baru() {
        // reset modal notif
        reset_notification();
        
        var no_tiket_new = $('#no_tiket_new').val();
        var noagenda_new = $('#noagenda_new').val();
        var permintaan_dari_new = $('#permintaan_dari_new').val();
        var jenis_transaksi_new = $('#jenis_transaksi_new').val();
        var jenis_transaksi_new_baru = $('#jenis_transaksi_new_baru').val();
        var perihal_new = $('#perihal_new').val();
        var no_ba_new = $('#no_ba_new').val();
        var nama_support_new = $('#nama_support_new').val();
        var tgl_permintaan_new = $('#tgl_permintaan_new').val();
        var resolution_new = $('#resolution_new').val();
        var status_data_new = $('#status_data_new').val();
        $('#form_tambah').ajaxForm({
            url: "<?php echo base_url('home/new_entry_process'); ?>",
            type: "POST",
            data: {"noagenda_new": noagenda_new, },
            beforeSend: function () {
                // loading
                $('#loading_modal').modal({
                    backdrop: 'static', keyboard: false
                });
                
                $('#modal_tambah').modal('hide');
            },
            success: function (msg) {
                
                $('#loading_modal').modal('hide');
                        
                var msg = $.parseJSON(msg);
                if (msg.status == 'Gagal') {
                    show_failed_notification(msg.status, msg.pesan);
                } else if (msg.status == 'Warning') {
                    show_warning_notification(msg.status, msg.pesan)
                } else if (msg.status == 'Sukses') {
                    
                    $("#no_tiket").val(msg.no_tiket);
                    $("#noba").val(msg.no_ba);
                    $("#noagenda").val(msg.noagenda);
                    // tampil modal sukses
                    show_success_notification(msg.status, msg.pesan);
                    // load
                    loaddata();
                }
            },  
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                $('#loading_modal').modal('hide');
                    $('#notifikasi').modal('show');
                    $('#notifikasi').addClass('modal-danger');
                    $('#font').addClass('fa-danger fa-fw');
                    $('#button_close').addClass('btn-danger');
                    $('#status').html(textStatus);
                    $('#teks').html(errorThrown);
            },
        });
    }

    function hapus() {
        // reset modal notif
        reset_notification();
        var no_tiket_del = $('#no_tiket_del').val();
        $('#form_delete').ajaxForm({
            url: "<?php echo base_url('home/delete_process'); ?>",
            type: "POST",
            data: {"no_tiket": no_tiket_del, },
            beforeSend: function () {
                $('#modal_delete').modal('hide');
                // $('#bcari').attr('disabled', 'disabled');
                $('#button_load').attr('disabled', 'disabled');
                $('#bsimpan').attr('disabled', 'disabled');
                // $('#button_refresh').attr('disabled', 'disabled');
                $('#bcari').attr('disabled', 'disabled');
                $('#btambah_new_entry').button('loading');
            },
            success: function (msg) {
                var msg = $.parseJSON(msg);
                if (msg.status == 'Gagal') {
                    show_failed_notification(msg.status, msg.pesan);
                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').attr('disabled', 'disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').removeAttr('disabled');
                    $('#btambah_new_entry').button('reset');
                } else if (msg.status == 'Warning') {
                    show_warning_notification(msg.status, msg.pesan)
                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').removeAttr('disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').removeAttr('disabled');
                    $('#btambah_new_entry').button('reset');
                } else if (msg.status == 'Sukses') {
                    // tampil modal sukses
                    show_success_notification(msg.status, msg.pesan);

                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').removeAttr('disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').removeAttr('disabled');
                    $('#btambah_new_entry').button('reset');
                    loaddata();
                }
            },
        });
    }
</script>
<script type="text/javascript">

    $('#tgl_catat').datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true
    });
    // set first
    $('#bsimpan').attr('disabled', 'disabled');

    function cari() {
        // reset modal notif
        reset_notification();
        var noagenda = $('#noagenda').val();
        var noba = $('#noba').val();
        var tgl_catat = $('#tgl_catat').val();
        var perihal = $('#perihal').val();
        $('#form_upload').ajaxForm({
            url: "<?php echo base_url('home/dokumen_cari'); ?>",
            type: "POST",
            data: {"noagenda": noagenda, "tgl_catat": tgl_catat, "perihal": perihal},
            beforeSend: function () {
                $('#bcari').attr('disabled', 'disabled');
                $('#button_load').attr('disabled', 'disabled');
                $('#bsimpan').attr('disabled', 'disabled');
                $('#button_refresh').attr('disabled', 'disabled');
                $('#bcari').button('loading');
            },
            success: function (msg) {
                var msg = $.parseJSON(msg);
                if (msg.status == 'Gagal') {
                    show_failed_notification(msg.status, msg.pesan);
                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').attr('disabled', 'disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').button('reset');
                } else if (msg.status == 'Warning') {
                    show_warning_notification(msg.status, msg.pesan)
                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').attr('disabled', 'disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').button('reset');
                } else if (msg.status == 'Sukses') {
                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').removeAttr('disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').button('reset');
                    loaddata();
                }
            },
        });
    }

    function simpan() {
        // reset modal notif
        reset_notification();
        
        var noagenda = $('#m_noagenda').val();
        var noba = $('#m_noba').val();
        var m_id_upload = $('#m_id_upload').val();
        $('#form_upload_file').ajaxForm({
            url: "<?php echo base_url('home/dokumen_process'); ?>",
            type: "POST",
            data: {"noagenda": noagenda, },
            beforeSend: function () {
                $('#modal_upload').modal('hide');
                $('#bcari').attr('disabled', 'disabled');
                $('#button_load').attr('disabled', 'disabled');
                $('#bsimpan').attr('disabled', 'disabled');
                $('#button_refresh').attr('disabled', 'disabled');
                $('#bcari').button('loading');
                // loading
                $('#loading_modal').modal({
                    backdrop: 'static', keyboard: false
                });
            },
            success: function (msg) {
                // close loading
                $('#loading_modal').modal('hide');
                var msg = $.parseJSON(msg);
                if (msg.status == 'Gagal') {
                    show_failed_notification(msg.status, msg.pesan);
                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').attr('disabled', 'disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').button('reset');
                } else if (msg.status == 'Warning') {
                    show_warning_notification(msg.status, msg.pesan)
                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').removeAttr('disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').button('reset');
                } else if (msg.status == 'Sukses') {
                    // tampil modal sukses
                    show_success_notification(msg.status, msg.pesan);
                    $('#bcari').removeAttr('disabled');
                    $('#button_load').removeAttr('disabled');
                    $('#bsimpan').removeAttr('disabled');
                    $('#button_refresh').removeAttr('disabled');
                    $('#bcari').button('reset');
                    loaddata();
                }
            },
        });
    }

    function loaddata() {
        var noagenda = $('#noagenda').val();
        var noba = $('#noba').val();
        var no_tiket = $('#no_tiket').val();
        var jenis_transaksi = $('#jenis_transaksi').val();
        var tgl_catat = $('#tgl_catat').val();
        var perihal = $('#perihal').val();
        var idpel = $('#idpel').val();
        var id_user = $('#id_user').val();
        var table;
        table = $('#table').DataTable({
            "ajax": {
                "url": "<?php echo base_url('home/dokumen_load_params') ?>",
                "type": "POST",
                "data": {"noagenda": noagenda, "noba": noba, "jenis_transaksi": jenis_transaksi, "id_user": id_user, "idpel": idpel, "no_tiket": no_tiket, "tgl_catat": tgl_catat, "perihal": perihal},
            },
            "paging": false,
            // "pageLength": 3,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
        });
        // $('#bcari').attr('disabled', 'disabled');
        table.destroy();
    }

    function modal_upload(noagenda, noba, m_jenis_transaksi, m_id_upload, m_no_tiket) {
        $('#modal_upload').modal('show');
        $("#m_noagenda").val('');
        $("#m_noagenda").val(noagenda);
        $("#m_noba").val('');
        $("#m_noba").val(noba);
        $("#m_jenis_transaksi").val('');
        $("#m_jenis_transaksi").val(m_jenis_transaksi);
        $("#m_id_upload").val('');
        $("#m_id_upload").val(m_id_upload);
        $("#m_no_tiket").val('');
        $("#m_no_tiket").val(m_no_tiket);

    }


    function to_excel() {
        $('#form_upload').attr('action', "<?php echo base_url('home/cetak_excel') ?>").submit();

    }
    $(".bexcel").on("click", function (e) {
        e.preventDefault();
        $('#form_upload').attr('action', "<?php echo base_url('home/cetak_excel') ?>").submit();
    });

<?php
if (isset($PESAN)) {
    ?>
        $(document).ready(function () {
            $('#notifikasi1').modal('show');
        });
    <?php
}
?>



</script>