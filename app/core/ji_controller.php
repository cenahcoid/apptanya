<?php
/**
* Main controller: contains about methods and protperties that automtically included after extending in a class
*/
class JI_Controller extends \SENE_Controller
{
  public $status = 404;
  public $message = 'Notfound';
  public $user_login = 0;
  public $admin_login = 0;

  public function __construct()
  {
    parent::__construct();
    $this->user_login = 0;
    $this->admin_login = 0;
    $this->status = 404;
    $this->message = 'Notfound';
  }

  public function __init()
  {
    $data = array();
    $sess = $this->getKey();
    if (!is_object($sess)) {
      $sess = new stdClass();
    }
    if (!isset($sess->user)) {
      $sess->user = new stdClass();
    }
    if (isset($sess->user->id)) {
      $this->user_login = 1;
    }

    if (!isset($sess->admin)) {
      $sess->admin = new stdClass();
    }
    if (isset($sess->admin->id)) {
      $this->admin_login = 1;
    }

    $data['sess'] = $sess;
    $data['produk_kategori'] = array();
    return $data;
  }

  /**
  * Output the json formatted string
  * @param  mixed     $dt     input object or array
  * @return string            sting json formatted with its header
  */
  public function __json_out($dt)
  {
    $this->lib('sene_json_engine', 'sene_json');
    $data = array();
    if (isset($_SERVER['SEME_MEMORY_VERBOSE'])) {
      $data["memory"] = round(memory_get_usage()/1024/1024, 5)." MBytes";
    }
    $data["status"]  = (int) $this->status;
    $data["message"] = $this->message;
    $data["data"]  = $dt;
    $this->sene_json->out($data);
    return true;
  }
  
  public function config_semevar($key, $default_value = '')
  {
    if (isset($this->config->semevar->{$key})) {
      return $this->config->semevar->{$key};
    } else {
      return $default_value;
    }
  }
  public function __dateIndonesia($datetime, $utype = 'hari_tanggal')
  {
    $stt = strtotime($datetime);
    $bulan_ke = date('n', $stt);
    $bulan = 'Desember';
    switch ($bulan_ke) {
      case '1':
          $bulan = 'Januari';
          break;
      case '2':
          $bulan = 'Februari';
          break;
      case '3':
          $bulan = 'Maret';
          break;
      case '4':
          $bulan = 'April';
          break;
      case '5':
          $bulan = 'Mei';
          break;
      case '6':
          $bulan = 'Juni';
          break;
      case '7':
          $bulan = 'Juli';
          break;
      case '8':
          $bulan = 'Agustus';
          break;
      case '9':
          $bulan = 'September';
          break;
      case '10':
          $bulan = 'Oktober';
          break;
      case '11':
          $bulan = 'November';
          break;
      default:
          $bulan = 'Desember';
    }
    $hari_ke = date('N', $stt);
    $hari = 'Minggu';
    switch ($hari_ke) {
      case '1':
          $hari = 'Senin';
          break;
      case '2':
          $hari = 'Selasa';
          break;
      case '3':
          $hari = 'Rabu';
          break;
      case '4':
          $hari = 'Kamis';
          break;
      case '5':
          $hari = 'Jumat';
          break;
      case '6':
          $hari = 'Sabtu';
          break;
      default:
          $hari = 'Minggu';
    }
    $utype == strtolower($utype);
    if ($utype == "hari") {
      return $hari;
    }
    if ($utype == "jam") {
      return date('H:i', $stt).' WIB';
    }
    if ($utype == "tanggal") {
      return ''.date('d', $stt).' '.$bulan.' '.date('Y', $stt);
    }
    if ($utype == "tanggal_jam") {
      return ''.date('d', $stt).' '.$bulan.' '.date('Y H:i', $stt).' WIB';
    }
    if ($utype == "hari_tanggal") {
      return $hari.', '.date('d', $stt).' '.$bulan.' '.date('Y', $stt);
    }
    if ($utype == "hari_tanggal_jam") {
      return $hari.', '.date('d', $stt).' '.$bulan.' '.date('Y H:i', $stt).' WIB';
    }
  }

  public function is_auto_login_after_register()
  {
    return $this->config_semevar('auto_login_after_register', false);
  }

  /**
  * Abstract layer for bootstraping class or onboarding class
  *   this is *required*
  * @return mixed server respose output
  */
  public function index()
  {
  }
}
