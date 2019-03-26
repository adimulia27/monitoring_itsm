<?php
$PESAN = $this->session->userdata('PESAN');
?>

<script type="text/javascript">
  
      function changeIcon(id_collapse) {
       // alert('Id = ' + id_collapse);
       $("#" + id_collapse).on('shown.bs.collapse', function() {
        $("#fa_" + id_collapse).addClass('fa-minus').removeClass('fa-plus');
      });
       $("#" + id_collapse).on('hidden.bs.collapse', function() {
        $("#fa_" + id_collapse).addClass('fa-plus').removeClass('fa-minus');
      });
     }

</script>

    <style type="text/css">
    .w-auto{

      margin-bottom: 2px;
    }
    .w-auto tbody > tr > td{
      color: #000;
    }
    .w-auto > thead > tr > th, .w-auto > tbody > tr > th, .w-auto > tfoot > tr > th, .w-auto > thead > tr > td, .w-auto > tbody > tr > td, .w-auto > tfoot > tr > td {
      padding: 0px;
      line-height: 1.42857;
      vertical-align: top;
      border-top: 1px solid #DDD;
      text-align: left;  
    }
    .detil > tbody > tr > td{
      font-size: 10px;
    }

    .detil > thead > tr > th{
      font-size: 10px;
      padding-left: 5px;
      padding-right: 5px;
      background-color: #3C8DBC;
    }
    .pohon1{
      margin-left: 30px;
    }
    .scroll-y {
      max-height: 300px;
      overflow-y: auto;
    }

  </style>
<input type="hidden" value="" id="noagendaVALUE">
<section class="content">

  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <div class="col-md-8">


      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <form id="form_upload" action="<?php echo site_url('statistik/search_process_harian/'); ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" >
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="col-sm-12 control-label"> STATISTIK PERTANGGAL  </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <input type="text" name="INTANGGAL" class="form-control" id="INTANGGAL" value="<?php echo $INTANGGAL; ?>" >
                      </div>
                    </div>                                  
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <button class="btn btn-primary" id="bcari"  name="button" value="cari" ><i class="fa fa-search fa-fw"></i> Cari</button>
                        <button class="btn btn-default" name="button" value="reset"><i class="fa  fa-refresh fa-fw" ></i> Reset</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">

        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- BAR CHART -->

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Tiket ITSM</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="chart-responsive">
                    <div id="family_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    <!-- <canvas id="pieChart" height="150"></canvas> -->
                  </div><!-- ./chart-responsive -->
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.box-body -->

            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-group" id="accordion"></div>
            </div>
            <!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col (RIGHT) -->
      </div><!-- /.row -->
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Tiket</span>
              <span class="info-box-number"><?php echo $total_tiket;?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-file-text-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Tiket Aktif </span>
              <span class="info-box-number"><?php echo $tiket_aktif;?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-check-square-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Tiket Resolved</span>
              <span class="info-box-number"><?php echo $tiket_resolved;?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
      </div><!-- /.row -->


      



    </div><!-- /.col -->
    <div class="col-md-4">
      <!-- Info Boxes Style 2 -->
      <div class="info-box bg-yellow">
        <span class="info-box-icon"><i class="glyphicon glyphicon-calendar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jakarta, Indonesia</span>
          <span class="info-box-number">
            <?php echo $waktu_sekarang['hari'] . ', ' . $waktu_sekarang['tanggal'] . ' ' . $waktu_sekarang['bulan'] . ' ' . $waktu_sekarang['tahun']; ?>
          </span>
          <div class="progress">
            <div class="progress-bar" style="width: 50%"></div>
          </div>
          <span class="progress-description">
            Statistik Tiket Masuk H-1| Div. Pelaporan AP2T
          </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Total Tiket dan Tiket Resolved H-1 Berdasarkan Family</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <div id="container"></div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Lainnya</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <div id="container-test">
              <p class="pull-right">
                <a href="<?php echo base_url('statistik/index');?>" class="btn btn-success btn-sm ad-click-event">
                  LIHAT STATISTIK PERHARI H-1
                </a>
                <a href="<?php echo base_url('statistik/bulanan');?>" class="btn btn-success btn-sm ad-click-event">
                  LIHAT STATISTIK PERBULAN
                </a>
              </p>
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<div class="modal fade modal-primary" id="modal_family">
    <div class="modal-dialog modal-lg" style="width: 90%">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="judul_header">Detail</h4>
          </div>
          <div class="modal-body" style="background-color: #FFF !important">
            <div class="box-body scroll-y">




              <div id="tb_incident">




              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="loading_modal">
      <div class="modal-dialog modal-sm" role="document">
        <img src="<?php echo base_url('assets/dist/img/ajax-loader.gif');?>" alt="" />
      </div>
    </div>
    




  <script>
	// highcharts
	  // Radialize the colors
    Highcharts.setOptions({
     colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
      return {
        radialGradient: {
        cx: 0.5,
        cy: 0.3,
        r: 0.7
        },
        stops: [
          [0, color],
    			[1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
           ]
        };
      })
    });
		// Build the chart
		Highcharts.chart('family_chart', {
			credits: {
				enabled: false
			},
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: "MONITORING TIKET AKTIF PERTANGGAL  <?php echo substr($INTANGGAL, 0,2) . ' ' . strtoupper($rs_bulan[substr($INTANGGAL, 3,2)]) . ' ' . $waktu_sekarang['tahun']; ?>"
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {y}',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						},
						connectorColor: 'silver'
					}
				}
			},
			series: [{
				name: 'Persentase',
				data: [
       <?php foreach ($rs_family as $i => $family) { ?>

        { 
          name: '<?php echo $family['SERVICEFAMILY']; ?>', 
          y: <?php echo $family['TOTAL']; ?> ,

          color: {
            //linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
            radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
            stops: [
            [0, 'YELLOW'],
            [1, "<?php  echo $rs_warna[$i]; ?>"]
            ]
          },
          //  color : "<?php  echo $rs_warna[$i]; ?>" ,
          events: {
            click: function() {
             modal_family(this.name);
           }
         }

       },

       <?php }?>
       ]
     }]
   });

    
  function modal_family(family) {
    document.getElementById("judul_header").innerHTML = "DETAIL TIKET AKTIF "+family;

    $("#tb_incident").html('<div></div>');
    var url = "<?php echo base_url('statistik/ajax_get_incident_harian') ?>";
        //var bidang_id = $(this).prop("lang");
        $.ajax({
          type: "POST",
          url: url,
          dataType: "html",
          data: {
            "family" : family,
            "INTANGGAL" : "<?php echo $INTANGGAL; ?>"
          },
          beforeSend: function () {
                // non removable loading
                $('#loading_modal').modal({
                  backdrop: 'static', keyboard: false
                });
              },
              success: function (data) {
                $('#loading_modal').modal('hide');
                $("#tb_incident").html(data);
                $('#modal_family').modal('show');
              }
            });

      } 

    </script>


    <script type="text/javascript">
  // bar chart
  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Grafik Tiket Per H-1'
    },
    xAxis: {
      categories: [
      <?php foreach ($rs_total_resolved['SERVICEFAMILY']  as $nama_family) {
        echo "'".$nama_family."',";
      } ?>
      //'AP2T',
      // 'P2APST',
      // 'BBO'
      ]
    },
    yAxis: [{
      min: 0,
      title: {
        text: 'Tiket'
      }
    }, {
      title: {
        text: ''
      },
      opposite: true
    }],
    legend: {
      shadow: false
    },
    tooltip: {
      shared: true
    },
    plotOptions: {
      column: {
        grouping: false,
        shadow: false,
        borderWidth: 0
      }
    },
    series: [
    {
      name: 'Total Tiket',
      color: 'rgb(176,224,230)',
      data: [ 
      <?php foreach ($rs_total_resolved['TOTAL']  as $total_tiket) {
        echo $total_tiket.",";
      } ?>
              // 150, 
              // 73, 
              // 20
              ],
              pointPadding: 0.0,

            }, 
            {
              name: 'Tiket Resolved',
              color: 'rgb(30,144,255)',
              data: [
              <?php foreach ($rs_total_resolved['TOTAL_RS']  as $total_rs) {
                echo $total_rs.",";
              } ?>
      //140, 90, 40
      ],
      pointPadding: 0.1,

    }
    ]
  });
</script>
<script>
  // $(function () {
  //   $('#family_detail').DataTable()
  // })

  $('#INTANGGAL').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true
  });
</script>

<script type="text/javascript">

  function cari(d) {

    var familyGroup = d.getAttribute("data-id");
    var table;
    table = $('#tb_'+familyGroup).DataTable({
      "ajax": {
      "url": "<?php echo base_url('statistik/dokumen_load_params') ?>",
      "type": "POST",
      "data": {"family": familyGroup},
    },
    "paging": true,
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
</script>

<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url('assets/plugins/chartjs/Chart.min.js');?>"></script>
<!-- page script -->


   