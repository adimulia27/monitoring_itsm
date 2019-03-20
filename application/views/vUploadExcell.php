<input type="hidden" value="" id="noagendaVALUE">
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <?php $flash_pesan = $this->session->flashdata('pesan') ?>
           <?php if (!empty($flash_pesan)) : ?>
            <div class="alert fade in  alert-success alert-dismissible" role="alert" id="auto-hide">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>  </button>
                <strong>Pesan :</strong>
                <?php echo $flash_pesan; ?>
            </div> 
        <?php endif ?>
        <?php $flash_pesan = $this->session->flashdata('gagal') ?>
        <?php if (!empty($flash_pesan)) : ?>
            <div class="alert fade in  alert-danger alert-dismissible" role="alert" id="auto-hide">
                <span class="fa fa-times-circle" aria-hidden="true"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>  </button>
                <strong>Pesan :</strong>
                <?php echo $flash_pesan; ?>
            </div>
        <?php endif ?>

        <div class="box box-primary">
            <form id="form_upload" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url('cexcell/importDataExcell')?>">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>File Import</strong></label>
                                <div class="col-sm-6">
                                    <input type="file" name="file" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Replace File</strong></label>
                                <div class="col-sm-6">
                                    <input type="checkbox" name="replace" id="replace" value="REPLACE" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                        <button type="submit" name="btn_upload_itsm" id="btn_upload_itsm" value="upload" class="btn btn-default"><span class="fa fa-upload"><strong> Upload Excel</strong></button>
                        <button type="submit" name="btn_kirim_itsm" id="btn_kirim_itsm" value="kirim" class="btn btn-primary pull-right"><span class="fa fa-arrow-right"><strong> Kirim Data To ITSM </strong></button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>INCIDENT</th>
                                <th>PRIORITYNAME</th>
                                <th>SLACLASS</th>                                
                                <th>CASEOWNER</th>                                
                                <th>CASEOWNEREMAIL</th>
                                <th>UNITINDUK</th>
                                <th>UNITPELAKSANA</th>
                                <th>UNITSUBPELAKSANA</th>
                                <th>COMPLAINANT</th>
                                <th>COMPLAINANTEMAIL</th>
                                <th>SUMMARY</th>
                                <th>SOURCE</th>				
                                <th>CALLTYPE</th>				
                                <th>STATUS</th>
                                <th>DESCRIPTION</th>
                                <th>SERVICEFAMILY</th>
                                <th>SERVICEGROUP</th>
                                <th>SERVICETYPE</th>
                                <th>CAUSE</th>
                                <th>CAUSECODE</th>
                                <th>RESOLUTION</th>
                                <th>CREATEDBY</th>
                                <th>CREATEDON</th>
                                <th>TASKCREATEDON</th>
                                <th>ASSIGNTO</th>
                                <th>ASSIGNEDON</th>
                                <th>RESOLVEDBY</th>
                                <th>RESOLVEDON</th>
                                <th>MODIFIEDBY</th>
                                <th>MODIFIEDON</th>
                                <th>CLOSEDBY</th>
                                <th>CLOSEDDATE</th>
                                <th>PRIORITY</th>
                                <th>SLALEVEL1_80%</th>
                                <th>SLALEVEL1</th>
                                <th>SLALEVEL2</th>
                                <th>SLALEVEL3</th>
                                <th>FIRSTCALLRESOLUTION</th>
                                
                            </tr>
                        </thead>
						<tbody>
                        <?php
                        foreach($uploadItsm as $itsm){	
                         ?>
						<tr>
                             <td>
								<?php 
									echo number_format($itsm['INCIDENT'], 0, '', '');
								?>
							</td>
							<td>
								<?php
									
										echo $itsm['PRIORITYNAME'];
									
								?>
							</td>
							<td>
								<?php
									
										echo $itsm['SLACLASS'];
									
								?>
							</td>
							<td>
								<?php
									$caseowner = strlen($itsm['CASEOWNER']);
									if($caseowner > 7){
										echo substr($itsm['CASEOWNER'], 0, 5).' '."..";
									}else{
										echo $itsm['CASEOWNER'];
									}
								?>
							</td>							
							<td>
								<?php
									$caseowneremail = strlen($itsm['CASEOWNEREMAIL']);
									if($caseowneremail > 9){
										echo substr($itsm['CASEOWNEREMAIL'], 0, 8).' '."..";
									}else{
										echo $itsm['CASEOWNEREMAIL'];
									}
								?>
							</td>
							<td>
								<?php
									$unitinduk = strlen($itsm['UNITINDUK']);
									if($unitinduk > 9){
										echo substr($itsm['UNITINDUK'], 0, 8).' '."..";
									}else{
										echo $itsm['UNITINDUK'];
									}
								?>
							</td>
							<td>
								<?php
									$unitpelaksana = strlen($itsm['UNITPELAKSANA']);
									if($cunitpelaksana > 9){
										echo substr($itsm['UNITPELAKSANA'], 0, 8).' '."..";
									}else{
										echo $itsm['UNITPELAKSANA'];
									}
								?>
							</td>
							<td>
								<?php
									$unitsubpelaksana = strlen($itsm['UNITSUBPELAKSANA']);
									if($unitsubpelaksana > 9){
										echo substr($itsm['UNITSUBPELAKSANA'], 0, 8).' '."..";
									}else{
										echo $itsm['UNITSUBPELAKSANA'];
									}
								?>
							</td>
							<td>
								<?php
									$complainant = strlen($itsm['COMPLAINANT']);
									if($complainant > 18){
										echo substr($itsm['COMPLAINANT'], 0, 15).' '."..";
									}else{
										echo $itsm['COMPLAINANT'];
									}
								?>
							</td>
							<td>
								<?php
									$complaintemail = strlen($itsm['COMPLAINANTEMAIL']);
									if($complaintemail > 18){
										echo substr($itsm['COMPLAINANTEMAIL'], 0, 15).' '."..";
									}else{
										echo $itsm['COMPLAINANTEMAIL'];
									}
								?>
							</td>
                            <td>
								<?php
									$summary = strlen($itsm['SUMMARY']);
									if($summary > 6){
										echo substr($itsm['SUMMARY'], 0, 6).' '."..";
									}else{
										echo $itsm['SUMMARY'];
									}
								?>
							</td>
                            <td><?php echo $itsm['SOURCE'];?></td>
                            <td>
								<?php
									$calltype = strlen($itsm['CALLTYPE']);
									if($calltype > 8){
										echo substr($itsm['CALLTYPE'], 0, 7).' '."..";
									}else{
										echo $itsm['CALLTYPE'];
									}
								?>
							</td>
                            <td>
                            	<?php

                            			echo $itsm['STATUS'];

                            	?>
                            </td>
                            <td>
								<?php
									$description = strlen($itsm['DESCRIPTION']);
									if($description > 8){
										echo substr($itsm['DESCRIPTION'], 0, 7).' '."..";
									}else{
										echo $itsm['DESCRIPTION'];
									}
								?>
							</td>
							<td><?php echo substr($itsm['SERVICEFAMILY'], 3, 13);?></td>
                            <td>
								<?php
									$servicegroup = strlen($itsm['SERVICEGROUP']);
									if($servicegroup > 11){
										echo substr($itsm['SERVICEGROUP'], 3, 11).' '."..";
									}else{
										echo $itsm['SERVICEGROUP'];
									}
								?>
							</td>
							<td>
								<?php
									$servicetype = strlen($itsm['SERVICETYPE']);
									if($servicetype > 11){
										echo substr($itsm['SERVICETYPE'], 3, 10).' '."..";
									}else{
										echo $itsm['SERVICETYPE'];
									}
								?>
							</td>
							<td>
								<?php
									$cause = strlen($itsm['CAUSE']);
									if($cause > 10){
										echo substr($itsm['CAUSE'], 0, 5).''."..";
									}else{
										echo $itsm['CAUSE'];
									}
								?>
							</td>
							<td>
								<?php
									$causecode = strlen($itsm['CAUSECODE']);
									if($causecode > 10){
										echo substr($itsm['CAUSECODE'], 0, 5).''."..";
									}else{
										echo $itsm['CAUSECODE'];
									}
								?>
							</td>
                            <td>
								<?php
									$resolution = strlen($itsm['RESOLUTION']);
									if($resolution > 10){
										echo substr($itsm['RESOLUTION'], 0, 9).''."..";
									}else{
										echo $itsm['RESOLUTION'];
									}
								?>
							</td>
                            <td>
								<?php
									$createby = strlen($itsm['CREATEDBY']);
									if($createby > 15){
										echo substr($itsm['CREATEDBY'], 0, 8).' '."..";
									}else{
										echo $itsm['CREATEDBY'];
									}
								?>
							</td>
							
							<td><?php echo $itsm['CREATEDON'];?></td>
							<td><?php echo $itsm['TASKCREATEDON'];?></td>							
							<td><?php echo $itsm['RESOLVEDBY'];?></td>
							<td><?php echo $itsm['RESOLVEDON'];?></td>
							<td><?php echo $itsm['MODIFIEDBY'];?></td>
							<td><?php echo $itsm['MODIFIEDON'];?></td>
							<td><?php echo $itsm['CLOSEDBY'];?></td>
							<td><?php echo $itsm['CLOSEDDATE'];?></td>
							<td><?php echo $itsm['PRIORITY'];?></td>
							<td><?php echo $itsm['SLALEVEL1_80'];?></td>
							<td><?php echo $itsm['SLALEVEL1'];?></td>
							<td><?php echo $itsm['SLALEVEL2'];?></td>
							<td><?php echo $itsm['SLALEVEL3'];?></td>							
							<td>
								<?php 
									$assignto = strlen($itsm['ASSIGNTO']);
									if($assignto > 8){
										echo substr($itsm['ASSIGNTO'], 0, 7).''."..";
									}else{
										echo $itsm['ASSIGNTO'];
									}
								?>
							</td>
							<td><?php echo $itsm['FIRSTCALLRESOLUTION'];?></td>
							<td><?php echo $itsm['ASSIGNEDON'];?></td>
						</tr>
						<?php };?>
						</tbody>
					</table>
                 </div>
                 <ul class="pagination pull-left">
                    <li>Menampilkan <?php echo empty($pagination['start']) ?  '0' :  $pagination['start']; ?>  - <?php echo empty($pagination['end']) ?  '0' :  $pagination['end']; ?> dari total <?php echo empty($pagination['total']) ?  '0' :  $pagination['total']; ?> data</li>
                </ul>
                <ul class="pagination pagination-xs pull-right">
                    <?php echo empty($pagination['data']) ?  '' :  $pagination['data']; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

</div>

</section>
<script type="text/javascript">
    $( "#btn_kirim_itsm" ).click(function() {
      return confirm( "Data akan dikirimkan ke tabel TIKET_ITSM. Lanjutkan ?" );
    });

    $( "#btn_upload_itsm" ).click(function() {

        if($("#replace").prop('checked') == true){
            
            return confirm( "Data pada file akan diupload. Lanjutkan ?" );
        }else{
            return confirm( "Data pada file akan diupload tanpa replace. Lanjutkan ? " + $('#btn_upload_itsm').is(":checked") );
        }
    });
</script>

