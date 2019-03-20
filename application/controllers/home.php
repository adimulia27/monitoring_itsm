<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('mdata');
        // LOAD LIBRARY
        $this->load->library('ftp');
        $sesi_login = $this->session->userdata('logged');
        if (!isset($sesi_login)) {
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    // <editor-fold defaultstate="collapsed" desc="Menu Dokumen - By Arif">

    public function dokumen() {
        $data['title'] = "Managemen Dokumen";
        $data['konten'] = "vdokumen";
        $data['rs_jenis_transaksi'] = $this->mdata->get_list_jenis_transaksi();
        $data['rs_nama_support'] = $this->mdata->get_list_nama_support();
        $this->load->view('home', $data);
    }

    public function dokumen_process() {

        $save['noagenda'] = $this->input->post('m_noagenda');
        $save['noba'] = $this->input->post('noba');
        $save['jenis_transaksi'] = $this->input->post('jenis_transaksi');
        $save['no_tiket'] = $this->input->post('m_no_tiket');
        // cek sudah ada file / belum
        $save['id_upload'] = $this->input->post('m_id_upload');
        if (empty($save['id_upload']) || $save['id_upload'] == '') {
            $save['id_upload'] = $this->mdata->generate_id();
            $aksi = 'simpan';
        } else {
            $aksi = 'ubah';
        }
        // validate
        if (empty($save['noagenda']) && empty($save['noba'])) {
            $gagal[] = "No Agenda / No BA tidak boleh kosong.";
        }
        if (empty($save['jenis_transaksi'])) {
            $warning[] = "Jenis Transaksi tidak boleh kosong.";
        }
        if (empty($_FILES['nama_file']['tmp_name'])) {
            $warning[] = "Pilih file untuk diunggah.";
        }
        $hitung = count($gagal);
        if ($hitung > 0) {
            $response['status'] = "Gagal";
            foreach ($gagal as $pesan_gagal) {
                $row = array();
                $row = "<p>- " . $pesan_gagal . "</p>";
                $hasilrow[] = $row;
            }
            $response['pesan'] = $hasilrow;
            echo json_encode($response);
            exit();
        }
        $hitung = count($warning);
        if ($hitung > 0) {
            $response['status'] = "Warning";
            foreach ($warning as $pesan_gagal) {
                $row = array();
                $row = "<p>- " . $pesan_gagal . "</p>";
                $hasilrow[] = $row;
            }
            $response['pesan'] = $hasilrow;
            echo json_encode($response);
            exit();
        }

        if (!empty($_FILES['nama_file']['tmp_name'])) {
            // load configurasi
            $config = $this->config->item('ftp_config');
            // untuk nama file sesuai dokumen
            $char = array(" ", "/", "(", ")");
            $filename = $save['id_upload'] . '_' . str_replace($char, '_', $_FILES['nama_file']['name']);
            // rename file
            /*
             * $temp = explode(".", $_FILES["nama_file"]["name"]);
             * $extension = end($temp);
             * $filename = $this->input->post('inNoAgenda') . '.' . $extension;
             */
            $save['nama_file'] = $filename;
            //$res = $this->mdata->save_data_dokumen($save);
            // cek koneksi ftp
            if ($this->ftp->connect($config)) {
                // upload parameter
                $locpath = $_FILES['nama_file']['tmp_name'];
                $rempath = "Berita_Acara_Pelaporan/" . date('Ym') . "/" . trim($save['jenis_transaksi']) . "/";
                $mode = "auto";
                $permissions = 0777;
                $servpath = $rempath . $filename;
                // mkdir if not exist
                $this->cek_dir($rempath);
                // upload ke server
                if ($this->ftp->upload($locpath, $servpath, $mode)) {
                    if ($aksi == 'simpan') {
                        // insert db
                        $params = array(
                            'ID_UPLOAD' => $save['id_upload'],
                            'NOAGENDA' => $save['noagenda'],
                            'NAMA_FILE' => $save['nama_file'],
                            'NO_TIKET' => $save['no_tiket'],
                            'PATH_FILE' => $rempath,
                            'NO_BA' => $save['noba'],
                            'JENIS_TRANSAKSI' => $save['jenis_transaksi'],
                            'MDB' => $this->session->userdata('id_user'),
                            'MDD' => date('Y-m-d H:i:s'),
                        );
                        $this->mdata->insert($params);
                    } else {
                        // insert db
                        $params = array(
                            'NOAGENDA' => $save['noagenda'],
                            'NAMA_FILE' => $save['nama_file'],
                            'NO_TIKET' => $save['no_tiket'],
                            'PATH_FILE' => $rempath,
                            'NO_BA' => $save['noba'],
                            'JENIS_TRANSAKSI' => $save['jenis_transaksi'],
                            'MDB' => $this->session->userdata('id_user'),
                            'MDD' => date('Y-m-d H:i:s'),
                        );
                        $where = array(
                            'ID_UPLOAD' => $save['id_upload'],
                        );
                        $this->mdata->update($params, $where);
                    }
                    // sukses upload
                    $response['status'] = "Sukses";
                    $response['pesan'] = "<p>- Data berhasil diunggah.</p>";
                    echo json_encode($response);
                } else {
                    $response['status'] = "Gagal";
                    $response['pesan'] = "<p>- Gagal mengunggah data.</p>";
                    echo json_encode($response);
                }
            } else {
                $response['status'] = "Gagal";
                $response['pesan'] = "<p>- Gagal mengunggah data. Error FTP Server </p>";
                echo json_encode($response);
            }
        }
    }

    public function new_entry_process() {

        $save['no_tiket'] = trim($this->input->post('no_tiket_new'));
        $save['noagenda'] = trim($this->input->post('noagenda_new'));
        $save['idpel'] = trim($this->input->post('idpel_new'));
        $save['permintaan_dari'] = $this->input->post('permintaan_dari_new');
        $save['jenis_transaksi'] = empty($this->input->post('jenis_transaksi_new_baru')) ? $this->input->post('jenis_transaksi_new') : $this->input->post('jenis_transaksi_new_baru');
        $save['perihal'] = $this->input->post('perihal_new');
        $save['no_ba'] = trim($this->input->post('no_ba_new'));
        $save['id_user'] = trim($this->input->post('id_user_new'));
        $save['tgl_permintaan'] = str_replace("/", "", $this->input->post('tgl_permintaan_new'));
        $save['resolution'] = $this->input->post('resolution_new');
        $save['status_data'] = $this->input->post('status_data_new');
        $action = $this->input->post('action_input');
        // validate
        if (empty($save['noagenda']) && empty($save['no_ba'])) {
            $warning[] = "No Agenda / No BA tidak boleh kosong.";
        }
        if (empty($save['idpel'])) {
            $warning[] = "IDPEL tidak boleh kosong.";
        }
        if (empty($save['jenis_transaksi'])) {
            $warning[] = "Jenis Transaksi tidak boleh kosong.";
        }
        if (empty($save['no_tiket'])) {
            $warning[] = "No Tiket tidak boleh kosong.";
        }
        $hitung = count($warning);
        if ($hitung > 0) {
            $response['status'] = "Gagal";
            foreach ($warning as $pesan_gagal) {
                $row = array();
                $row = "<p>- " . $pesan_gagal . "</p>";
                $hasilrow[] = $row;
            }
            $response['pesan'] = $hasilrow;
            echo json_encode($response);
            exit();
        } else {
            if ($action == 'TAMBAH') {
                // insert db
                $params = array(
                    'NO_TIKET' => $save['no_tiket'],
                    'NOAGENDA' => $save['noagenda'],
                    'IDPEL' => $save['idpel'],
                    'PERMINTAAN_DARI' => $save['permintaan_dari'],
                    'JENIS_TRANSAKSI' => $save['jenis_transaksi'],
                    'PERIHAL' => $save['perihal'],
                    'NO_BA' => $save['no_ba'],
                    'TGL_PERMINTAAN' => $save['tgl_permintaan'],
                    'RESULOTION' => $save['resolution'],
                    'STATUS' => $save['status_data'],
                    'ID_USER' => $save['id_user'],
                );
                if ($this->mdata->insert_new_entry($params)) {
                    // sukses upload
                    $response['status'] = "Sukses";
                    $response['pesan'] = "<p>- Data berhasil disimpan.</p>";
                    // untuk default value search
                    $response['no_tiket'] = $save['no_tiket'];
                    $response['noagenda'] = $save['noagenda'];
                    $response['no_ba'] = $save['no_ba'];
                    echo json_encode($response);
                } else {
                    $response['status'] = "Gagal";
                    $response['pesan'] = "<p>- Data gagal disimpan.</p>";
                    echo json_encode($response);
                }
            } elseif ($action == 'EDIT') {
                // insert db
                $params = array(
                    'NO_TIKET' => $save['no_tiket'],
                    'NOAGENDA' => $save['noagenda'],
                    'IDPEL' => $save['idpel'],
                    'PERMINTAAN_DARI' => $save['permintaan_dari'],
                    'JENIS_TRANSAKSI' => $save['jenis_transaksi'],
                    'PERIHAL' => $save['perihal'],
                    'NO_BA' => $save['no_ba'],
                    'TGL_PERMINTAAN' => $save['tgl_permintaan'],
                    'RESULOTION' => $save['resolution'],
                    'STATUS' => $save['status_data'],
                    'ID_USER' => $save['id_user'],
                );
                $where = array(
                    'NO_TIKET' => $this->input->post('no_tiket_now'),
                    'NOAGENDA' => $this->input->post('noagenda_now'),
                    'IDPEL' => $this->input->post('idpel_now'),
                    'NO_BA' => $this->input->post('no_ba_now'),
                );
                if ($this->mdata->update_new_entry($params, $where)) {

                    // update jg di tabel upload_log
                    $params = array(
                        'NO_TIKET' => $save['no_tiket'],
                        'NOAGENDA' => $save['noagenda'],
                        'NO_BA' => $save['no_ba'],
                    );
                    $where = array(
                        'NO_TIKET' => $this->input->post('no_tiket_now'),
                        'NOAGENDA' => $this->input->post('noagenda_now'),
                        'NO_BA' => $this->input->post('no_ba_now'),
                    );
                    $this->mdata->update($params, $where);
                    // sukses upload
                    $response['status'] = "Sukses";
                    $response['pesan'] = "<p>- Data berhasil disimpan.</p>";
                    // untuk default value search
                    $response['no_tiket'] = $save['no_tiket'];
                    $response['noagenda'] = $save['noagenda'];
                    $response['no_ba'] = $save['no_ba'];
                    echo json_encode($response);
                } else {
                    $response['status'] = "Gagal";
                    $response['pesan'] = "<p>- Data gagal disimpan.</p>";
                    echo json_encode($response);
                }
            }
        }
    }

    public function delete_process() {

        $save['no_tiket'] = $this->input->post('no_tiket_del');
        $save['noagenda'] = $this->input->post('noagenda_del');
        $save['no_ba'] = $this->input->post('no_ba_del');
        // validate
        if (empty($save['noagenda']) && empty($save['no_ba']) && empty($save['no_tiket'])) {
            $warning[] = "Gagal menghapus. Data NO_TIKET / NOAGENDA / NO_BA tidak boleh kosong.";
        }
        $hitung = count($warning);
        if ($hitung > 0) {
            $response['status'] = "Warning";
            foreach ($warning as $pesan_gagal) {
                $row = array();
                $row = "<p>- " . $pesan_gagal . "</p>";
                $hasilrow[] = $row;
            }
            $response['pesan'] = $hasilrow;
            echo json_encode($response);
            exit();
        } else {
            $where = array(
                'NO_TIKET' => $save['no_tiket'],
                'NOAGENDA' => $save['noagenda'],
                'NO_BA' => $save['no_ba'],
            );
            if ($this->mdata->delete_data_ophar($where)) {

                $this->mdata->delete_data_upload($where);
                // sukses upload
                $response['status'] = "Sukses";
                $response['pesan'] = "<p>- Data #NO_TIKET : " . $save['no_tiket'] . " telah dihapus.</p>";
                echo json_encode($response);
            } else {
                $response['status'] = "Gagal";
                $response['pesan'] = "<p>- Data gagal dihapus.</p>";
                echo json_encode($response);
            }
        }
    }

    // LOAD DATA TABLE
    public function dokumen_load_params() {
        $noagenda = $this->input->post('noagenda');
        $noba = $this->input->post('noba');
        $jenis_transaksi = $this->input->post('jenis_transaksi');
        $no_tiket = $this->input->post('no_tiket');
        $tgl_catat = $this->input->post('tgl_catat');
        $perihal = $this->input->post('perihal');
        // get params
        $noagenda = empty($noagenda) ? '%' : $noagenda;
        $noba = empty($noba) ? '%' : $noba;
        $jenis_transaksi = empty($jenis_transaksi) ? '%' : $jenis_transaksi;
        $no_tiket = empty($no_tiket) ? '%' : $no_tiket;
        $tgl_catat = empty($tgl_catat) ? '%' : $tgl_catat;
        $perihal = empty($perihal) ? '%' : $perihal;
        // parameter
        $params = array($noagenda, $noba, $jenis_transaksi, $no_tiket, $tgl_catat, $perihal);
        $res = $this->mdata->get_list_opharapp_by_params($params);
        // get data
        if (empty($res)) {
            $output = array(
                "data" => [],
            );
            echo json_encode($output);
        } else {
            $session_data['rs_ophar'] = $res;
            $this->session->set_userdata($session_data);
            foreach ($res as $data) {
                $row = array();
                $delete = "<a href='#' class='btn btn-danger btn-xs' onclick='modal_delete(\"" . $data['NOAGENDA'] . "\" , \"" . $data['NO_BA'] . "\" , \"" . $data['JENIS_TRANSAKSI'] . "\" , \"" . $data['NO_TIKET'] . "\")' ><i class='fa fa-trash'></i> </a> &nbsp;";
                $edit = "<a href='#' class='btn btn-primary btn-xs' onclick='modal_edit(\"" . $data['NOAGENDA'] . "\" , \"" . $data['NO_BA'] . "\" , \"" . $data['JENIS_TRANSAKSI'] . "\" , \"" . $data['NO_TIKET'] . "\")' ><i class='fa fa-pencil'></i> Edit</a> &nbsp;";
                $upload_edit = "<a href='#' class='btn btn-primary btn-xs' onclick='modal_upload(\"" . $data['NOAGENDA'] . "\" , \"" . $data['NO_BA'] . "\" , \"" . $data['JENIS_TRANSAKSI'] . "\" , \"" . $data['ID_UPLOAD'] . "\" , \"" . $data['NO_TIKET'] . "\")' ><i class='fa fa-upload'></i> Unggah</a> &nbsp;";
                $download = "<a href=' " . site_url('home/download/' . $data['ID_UPLOAD']) . " ' class='btn btn-warning btn-xs'><i class='fa fa-download'></i> Unduh</a> " . $data['NAMA_FILE'] . "&nbsp;";
                $upload_add = "<a href='#' class='btn btn-primary btn-xs' onclick='modal_upload(\"" . $data['NOAGENDA'] . "\" , \"" . $data['NO_BA'] . "\" , \"" . $data['JENIS_TRANSAKSI'] . "\" , \"" . '' . "\" , \"" . $data['NO_TIKET'] . "\")' ><i class='fa fa-upload'></i> Unggah</a> &nbsp;";
                $download_disabled = "<a href='#' class='btn btn-default btn-xs' disabled><i class='fa fa-download'></i> Unduh</a> ";
                if (!empty($data['ID_UPLOAD'])) {
                    $button_file = $delete . $edit . $upload_edit . $download;
                } else {
                    $button_file = $delete . $edit . $upload_add . $download_disabled;
                }
                $row[] = $data['NO_TIKET'];
                $row[] = $data['NOAGENDA'];
                $row[] = $data['JENIS_TRANSAKSI'];
				$row[] = $data['IDPEL'];
				$row[] = $data['ID_USER'];
                $row[] = $data['NO_BA'];
                $row[] = $data['TGL_CATAT'];
                $row[] = $data['PERIHAL'];
                $row[] = $button_file;
                $dataarray[] = $row;
            }
            $output = array(
                "data" => $dataarray
            );
            echo json_encode($output);
        }
    }

    // passing value for edit
    public function get_edit_value() {
        $noagenda = $this->input->post('noagenda');
        $noba = $this->input->post('noba');
        $no_tiket = $this->input->post('no_tiket');
        // parameter
        $params = array($noagenda, $noba, $no_tiket);
        $res = $this->mdata->get_detail_opharappp($params);
        // get data
        if (empty($res)) {
            $output = array(
                "data" => '',
            );
            echo json_encode($output);
        } else {

            $output = array(
                "data" => $res
            );
            echo json_encode($output);
        }
    }

    public function testing_data() {
        $response['status'] = "Sukses";
        $response['pesan'] = "<p>- Data tersedia</p>";
        echo json_encode($response);
    }

    // method for : Cari dokumen
    public function dokumen_cari() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // -
            $noagenda = $this->input->post('noagenda');
            $noba = $this->input->post('noba');
            $jenis_transaksi = $this->input->post('jenis_transaksi');
            $no_tiket = $this->input->post('no_tiket');
            $tgl_catat = $this->input->post('tgl_catat');
            $perihal = $this->input->post('perihal');
            // cek
            if (empty($noagenda) && empty($noba) && empty($jenis_transaksi) && empty($no_tiket) && empty($tgl_catat)&& empty($perihal)) {
                $response['status'] = "Warning";
                $response['pesan'] = "<p>- Silahkan isi form pencarian.</p>";
                echo json_encode($response);
            } else {
                // sukses upload
                $response['status'] = "Sukses";
                $response['pesan'] = "<p>- Data berhasil diunggah.</p>";
                echo json_encode($response);
            }
        }
    }

    public function cek_dir($dir_path) {
        $config = $this->config->item('ftp_config');
        // connect FTP
        if ($this->ftp->connect($config)) {
            // mkdir
            $dir = explode('/', trim($dir_path, '/'));
            $tmp = "/";
            foreach ($dir as $rec) {
                if (!empty($rec)) {
                    $dest = $rec . '/';
                    $tmp .= $dest;
                    $is_dir = is_dir("ftp://" . $config['username'] . ":" . $config['password'] . "@" . $config['hostname'] . $tmp);
                    if (!$is_dir) {
                        $this->ftp->mkdir($tmp, NULL);
                    }
                }
            }
        }
    }

    // download file on ftp server
    public function download($id_upload = "") {
        // -
        $result = $this->mdata->get_file_by_id($id_upload);
        if (empty($result)) {
            redirect('home/dokumen');
        }
        // load configurasi
        $config = $this->config->item('ftp_config');
        // connect FTP
        if ($this->ftp->connect($config)) {
            // file ftp
            $list_file = $this->ftp->list_files($result['PATH_FILE']);
            $file = $result['PATH_FILE'] . $result['NAMA_FILE'];
            if (in_array($file, $list_file)) {
                // download
                header('Content-type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $result['NAMA_FILE'] . '"');
                if ($this->ftp->download($file, 'php://output', 'binary')) {
                    return TRUE;
                }
            }
        } else {
            echo "Error koneksi pada server FTP." . '<a href="#" onclick="window.history.back();return false;">Kembali</a>';
            exit();
        }
        return FALSE;
    }

    // method for : Cari dokumen
    public function cetak_excel() {
        // -

        $noagenda = $this->input->post('noagenda');
        $noba = $this->input->post('noba');
        $jenis_transaksi = $this->input->post('jenis_transaksi');
        $no_tiket = $this->input->post('no_tiket');
        $tgl_catat = $this->input->post('tgl_catat');
        // get params
        $noagenda = empty($noagenda) ? '%' : $noagenda;
        $noba = empty($noba) ? '%' : $noba;
        $jenis_transaksi = empty($jenis_transaksi) ? '%' : $jenis_transaksi;
        $no_tiket = empty($no_tiket) ? '%' : $no_tiket;
        $tgl_catat = empty($tgl_catat) ? '%' : $tgl_catat;
        // parameter
        $params = array($noagenda, $noba, $jenis_transaksi, $no_tiket, $tgl_catat);

        $data['rs_data'] = $this->session->userdata('rs_ophar');
        $this->load->view('v_excel', $data);
    }

    // </editor-fold>
}
