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

<input type="hidden" value="" id="noagendaVALUE">
<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <form id="form_upload" action="<?php echo site_url('statistik/search_process_bulanan/'); ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" >
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="col-sm-12 control-label"> STATISTIK PADA BULAN  </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <select name="bulan" id="bulan" class="form-control">
                          <option value="">--- Pilih Bulan ---</option>
                          <?php foreach ($rs_bulan as $mm => $month) { ?>
                          <option value="<?php echo $mm; ?>" <?php if ($search['bulan'] == $mm) {
                            echo " selected";
                          } ?> ><?php echo $month; ?></option>   
                          <?php } ?>
                        </select>
                      </div>
                    </div>                                  
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <select name="tahun" id="tahun" class="form-control">
                          <option value="">--- Pilih Tahun ---</option>
                          <?php foreach ($rs_tahun as $index => $tahun) { ?>
                          <option value="<?php echo $tahun; ?>" <?php if ($search['tahun'] == $tahun) {
                            echo " selected";
                          } ?>><?php echo $tahun; ?></option>   
                          <?php } ?>
                        </select>
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
            <span class="info-box-icon bg-red"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total OverSLA</span>
              <span class="info-box-number"><?php echo $tiket_oversla;?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-check-square-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Resolved</span>
              <span class="info-box-number"><?php echo $tiket_resolved;?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Tiket Bulan <?php echo $waktu_sekarang['bulan'];?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <div id="totat_tiket_barchart"></div>
              </div>
            </div><!-- /.box-body -->
          </div><!-- /.box -->

        </div><!-- /.col (RIGHT) -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Tiket Bulan <?php echo $waktu_sekarang['bulan'];?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <div id="totat_sla_barchart"></div>
              </div>
            </div><!-- /.box-body -->
          </div><!-- /.box -->

        </div><!-- /.col (RIGHT) -->
      </div><!-- /.row -->




    </div><!-- /.col -->





    <div class="col-md-4">
      <!-- Info Boxes Style 2 -->
      <div class="info-box bg-yellow">
        <span class="info-box-icon"><i class="glyphicon glyphicon-calendar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jakarta, Indonesia</span>
          <span class="info-box-number"><?php echo $waktu_sekarang['hari'] . ', ' . $waktu_sekarang['tanggal'] . ' ' . $waktu_sekarang['bulan'] . ' ' . $waktu_sekarang['tahun']; ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: 50%"></div>
          </div>
          <span class="progress-description">
            Statistik Tiket Masuk | Div. Pelaporan AP2T
          </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->

      <!-- BAR CHART -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Tiket Tahun <?php echo $search['tahun'];?></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="barChart" style="height:230px"></canvas>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <!-- PRODUCT LIST -->

      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Tiket Perhari</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <div id="container-test">
              <p class="pull-right">
                <a href="<?php echo base_url('statistik');?>" class="btn btn-success btn-sm ad-click-event">
                  LIHAT STATISTIK PERHARI H-1
                </a>
                <a href="<?php echo base_url('statistik/harian');?>" class="btn btn-success btn-sm ad-click-event">
                  LIHAT STATISTIK PERHARI
                </a>
              </p>
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <!-- /.box -->

      <div class="modal fade modal-primary" id="modal_family">
    <div class="modal-dialog modal-lg" style="width: 90%; max-height: 600px;overflow-y: auto;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="judul_header">Detail</h4>
          </div>
          <div class="modal-body" style="background-color: #FFF !important">
            <div class="box-body scroll-y">




              <div id="tb_incident1">




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


        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
    



<script type="text/javascript">
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
  // Bar Chart total tiket
  Highcharts.chart('totat_tiket_barchart', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Total Tiket'
    },
    xAxis: {
      categories: [
        <?php foreach ($rs_total_tiket as $nama_family) {
          echo "'".$nama_family['SERVICEFAMILY']."',";
        } ?>
      ]
    },
    yAxis: [{
      min: 0,
      title: {
        text: 'TIKET'
      }
    }, {
      title: {
        text: '-'
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
        borderWidth: 0,
        cursor: 'pointer',
      }
    },
    series: [
    // {
    //     name: 'Total Tiket',
    //     color: 'rgba(165,170,217,1)',
    //     data: [150, 73, 20],
    //     pointPadding: 0.3,

    // }, 
    {
      name: 'TOTAL TIKET',
      // color: 'rgba(126,86,134,.9)',
      data: [
        <?php foreach ($rs_total_tiket  as $total_tiket) {
        echo $total_tiket['TOTAL'].",";
      } ?>
      //140, 90, 40
      ],
      pointPadding: 0.1,
      point: {
             events: {
                click: function() {
                     modal_family(this.category);
                     //alert ('Category: '+ this.category +', value: '+ this.y);
                }
            }
        },

      events : function() {
        totat_tiket_barchart(this.name);
      }
    }]
  });

function modal_family(family) {
    document.getElementById("judul_header").innerHTML = "AVERAGE OF RESPONSE TIME RESOLVED ON";
    // alert(<?php echo $search['bulan'].$search['tahun']; ?>);
    $("#tb_incident1").html('<div></div>');
    var url = "<?php echo base_url('statistik/ajax_get_incident_bulanan') ?>";
        //var bidang_id = $(this).prop("lang");
        $.ajax({
          type: "POST",
          url: url,
          dataType: "html",
          data: {
            'family' :family,
            // "BLTH" : "032019"
            'BLTH' : "<?php echo $search['tahun'].$search['bulan']; ?>"
          },
          beforeSend: function () {
                // non removable loading
                $('#loading_modal').modal({
                  backdrop: 'static', keyboard: false
                });
              },
              success: function (data) {
                $('#loading_modal').modal('hide');
                $('#modal_family').modal('show');
                $("#tb_incident1").html(data);
               
               //console.log(data);
              }
            });

} 

</script>




<script type="text/javascript">
  // Bar Chart total SLA
  Highcharts.chart('totat_sla_barchart', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Tiket Over SLA'
    },
    xAxis: {
      categories: [

      <?php foreach ($rs_tiket_sla as $data) {
        echo "'".$data['SERVICEFAMILY']."',";
      } ?>
      
      ]
    },
    yAxis: [{
      min: 0,
      title: {
        text: 'Tiket'
      }
    }, {
      title: {
        text: '-'
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
      name: 'Over SLA',
      color: 'rgba(165,170,217,1)',
      data: [
        <?php foreach ($rs_tiket_sla  as $data) {
          echo $data['TOTAL_SLA'].",";
        } ?>
      ],
      pointPadding: 0.1,
      point: {
             events: {
                click: function() {
                    //modal_grafik(this.category);
                     console.log ('Category: ');
                }
            }
        },
    }, 
    // {
    //     name: 'Tiket Resolved',
    //     color: 'rgba(126,86,134,.9)',
    //     data: [140, 90, 40],
    //     pointPadding: 0.4,

    // }
    ]
  });
</script>





<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url('assets/plugins/chartjs/Chart.min.js');?>"></script>
<!-- page script -->
<script>
  $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
         var areaChartData = {
          labels: [
          <?php foreach ($rs_tiket_bulanan as $dt_tiket) { 
            $dt = DateTime::createFromFormat('!m', $dt_tiket['BULAN']);
            echo '"' . $dt->format('M') . '",' ;
          }?>
          ],
          datasets: [
          {
            label: "Electronics",
            fillColor: "rgba(210, 214, 222, 1)",
            strokeColor: "rgba(210, 214, 222, 1)",
            pointColor: "rgba(210, 214, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [
            <?php foreach ($rs_tiket_bulanan as $dt_tiket) { 
              echo $dt_tiket['TIKET_PERBULAN'] . ',';
            }?>
            ]
          }
          ]
        };

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        barChartData.datasets[0].fillColor = "#00a65a";
        barChartData.datasets[0].strokeColor = "#00a65a";
        barChartData.datasets[0].pointColor = "#00a65a";
        var barChartOptions = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: true,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - If there is a stroke on each bar
          barShowStroke: true,
          //Number - Pixel width of the bar stroke
          barStrokeWidth: 2,
          //Number - Spacing between each of the X value sets
          barValueSpacing: 5,
          //Number - Spacing between data sets within X values
          barDatasetSpacing: 1,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to make the chart responsive
          responsive: true,
          maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);
      });
    </script>
