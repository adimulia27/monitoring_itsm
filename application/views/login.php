<html>

    <head>

        <meta charset="UTF-8">
        <title>Login Aplikasi</title>
        <link rel="shortcut icon" href="<?php echo base_url('assets/icon/favicon.ico');?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/fontawesome/css/font-awesome.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/iCheck/square/blue.css'); ?>" rel="stylesheet" type="text/css" />

    
    </head>
  
    <body class="login-page">
        <div class="login-box">           
            <div class="login-box-body">
                <p class="login-box-msg">Aplikasi Monitoring Rekonsiliasi Laporan AP2T</p>
                <!-- <div id="gagal" style="display:none;" class="alert alert-danger alert-dismissable">
                    <div id="teks"></div>
                </div> -->
                <form id="formlogin"class="form">
                    <input type="hidden" name="proseslogin" id="proseslogin" value="proseslogin">
                    <div class="form-group has-feedback">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username"/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button onclick="login()" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                    </div> 
                </form> 
            </div>
        </div>
        <div id="notifikasi" class="modal fade bs-example-modal-sm modal-danger" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5><i class="fa fa-warning fa-fw"></i>Gagal</h5>
                    </div>
                    <div class="modal-body">
                        <p id="teks"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        <script>
        function login(){
            var proseslogin=$('#proseslogin').val();
            var username=$('#username').val();
            var password=$('#password').val();
            $('#gagal').hide('fast');
            $('#formlogin').ajaxForm ({
                type: "POST",
                url: "<?php echo base_url('auth/ceklogin'); ?>",
                data: {"proseslogin":proseslogin, "username":username, "password":password},
                 success: function(msg) {
                    var msg=$.parseJSON(msg);
                    if (msg.status=='Sukses') {
                        window.location.replace(msg.url);
                       // window.location.href=(msg.url);
                    }
                    else if (msg.status=='Gagal') {
                        $('#notifikasi').modal('show');                   
                        $('#teks').html(msg.pesan);
                    }
                    
                },
            });
        }
        </script>
    </body>
</html>