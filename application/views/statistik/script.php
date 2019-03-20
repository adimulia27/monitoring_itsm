

    <script type="text/javascript">

 
  function modal_family(family) {
    document.getElementById("judul_header").innerHTML = "DETAIL TIKET AKTIF " + family;

    $("#tb_incident").html('<div></div>');
    var url = "<?php echo base_url('statistik/ajax_get_incident_data') ?>";
        //var bidang_id = $(this).prop("lang");
        $.ajax({
          type: "POST",
          url: url,
          //dataType: "html",
          cache: false,
          data: {
            family : family
          },
          success: function(response){
              var obj = JSON.parse(response);
              console.log(obj);
              }
        });

        //
        $('#modal_family').modal('show');
      } 
      
    </script>


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
				text: "MONITORING TIKET AKTIF PERTANGGAL  <?php echo $waktu_kemarin['tanggal'] . ' ' . strtoupper($waktu_kemarin['bulan']) . ' ' . $waktu_kemarin['tahun']; ?>"
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


     }

     ]
   });
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
