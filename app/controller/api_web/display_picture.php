<?php
/**
* API_Front/user
*/
class Display_Picture extends \JI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load("api_web/b_user_model", 'bum');
  }

  protected function __uploadImage($keyname, $id, $ke="")
  {
    $sc = new stdClass();
    $sc->status = 500;
    $sc->message = 'Error';
    $sc->image = '';
    $sc->thumb = '';
    if (isset($_FILES[$keyname]['name'])) {
      if ($_FILES[$keyname]['size']>2000000) {
        $sc->status = 301;
        $sc->message = 'Ukuran gambar terlalu besar. Silakan pilih dengan ukuran kurang dari 2 MB';
        return $sc;
      }
      $filenames = pathinfo($_FILES[$keyname]['name']);
      if (isset($filenames['extension'])) {
        $fileext = strtolower($filenames['extension']);
      } else {
        $fileext = 'jpg';
      }

      if (!in_array($fileext, array("jpg","png","jpeg","gif"))) {
        $sc->status = 303;
        $sc->message = 'Invalid file extension, please try other image file.';
        return $sc;
      }
      $filename = "$id-$ke";
      $filethumb = $filename.'-thumb';

      $targetdir = $this->config_semevar('media_user', 'media/user');
      $targetdircheck = realpath(SEMEROOT.$targetdir);
      if (empty($targetdircheck)) {
        if (PHP_OS == "WINNT") {
          if (!is_dir(SEMEROOT.$targetdir)) {
            mkdir(SEMEROOT.$targetdir);
          }
        } else {
          if (!is_dir(SEMEROOT.$targetdir)) {
            mkdir(SEMEROOT.$targetdir, 0775);
          }
        }
      }

      $tahun = date("Y");
      $targetdir = $targetdir.DIRECTORY_SEPARATOR.$tahun;
      $targetdircheck = realpath(SEMEROOT.$targetdir);
      if (empty($targetdircheck)) {
        if (PHP_OS == "WINNT") {
          if (!is_dir(SEMEROOT.$targetdir)) {
            mkdir(SEMEROOT.$targetdir);
          }
        } else {
          if (!is_dir(SEMEROOT.$targetdir)) {
            mkdir(SEMEROOT.$targetdir, 0775);
          }
        }
      }

      $bulan = date("m");
      $targetdir = $targetdir.DIRECTORY_SEPARATOR.$bulan;
      $targetdircheck = realpath(SEMEROOT.$targetdir);
      if (empty($targetdircheck)) {
        if (PHP_OS == "WINNT") {
          if (!is_dir(SEMEROOT.$targetdir)) {
            mkdir(SEMEROOT.$targetdir);
          }
        } else {
          if (!is_dir(SEMEROOT.$targetdir)) {
            mkdir(SEMEROOT.$targetdir, 0775);
          }
        }
      }

      $sc->status = 998;
      $sc->message = 'Invalid file extension uploaded';
      if (in_array($fileext, array("gif", "jpg", "png","jpeg"))) {
        $filecheck = SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename.'.'.$fileext;
        if (file_exists($filecheck)) {
          unlink($filecheck);
          $rand = rand(0, 999);
          $filename = "$id-$ke-".$rand;
          $filecheck = SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename.'.'.$fileext;
          if (file_exists($filecheck)) {
            unlink($filecheck);
            $rand = rand(1000, 99999);
            $filename = "$id-$ke-".$rand;
          }
        }
        $filethumb = $filename."-thumb.".$fileext;
        $filename = $filename.".".$fileext;

        move_uploaded_file($_FILES[$keyname]['tmp_name'], SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename);
        if (is_file(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename) && file_exists(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename)) {
          if (@mime_content_type(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename) == 'image/webp') {
            $sc->status = 302;
            $sc->message = 'WebP image format currently unsupported';
            return $sc;
          }

          if (file_exists(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filethumb) && is_file(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filethumb)) {
            unlink(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filethumb);
          }
          if (file_exists(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename) && is_file(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename)) {
            $this->lib("seme_imageresize");
            $this->seme_imageresize->load(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filename)->resize(370)->saveToFile(SEMEROOT.$targetdir.DIRECTORY_SEPARATOR.$filethumb);
            $sc->status = 200;
            $sc->message = 'Successful';
            $sc->thumb = str_replace("//", "/", $targetdir.'/'.$filethumb);
            $sc->image = str_replace("'\'", "/", $targetdir.'/'.$filename);
            $sc->image = str_replace("//", "/", $targetdir.'/'.$filename);
          } else {
            $sc->status = 997;
            $sc->message = 'Failed: file image not exists';
          }
        } else {
          $sc->status = 999;
          $sc->message = 'Upload file failed';
        }
      } else {
        $sc->status = 998;
        $sc->message = 'Invalid file extension uploaded';
      }
    } else {
      $sc->status = 988;
      $sc->message = 'Keyname file does not exists';
    }
    return $sc;
  }

  public function index()
  {
    $dt = $this->initialize_data();
    $data = array();
    $this->__json_out($data);
  }

  public function change(){
    $dt = $this->initialize_data();

    //default result
    $data = array();
    $data['display_picture'] = '';

    //check apikey or logged in user
    if(!isset($dt['sess']->user->id)){
      $this->status = 401;
      $this->message = 'Missing or invalid API key';
      $this->__json_out($data);
      die();
    }
    $b_user_id = $dt['sess']->user->id;

    $du = array();
    $sc = $this->__uploadImage("display_picture", $b_user_id, "1");
    if(!is_object($sc)) $sc = new stdClass();
    if(!isset($sc->status)) $sc->status=0;
    if(!isset($sc->message)) $sc->message='no response from upload processor';
    if($sc->status == 200){
      $du['display_picture'] = $sc->image;
      $res = $this->bum->update($b_user_id, $du);
      if($res){
        $this->status = 200;
        $this->message = "Berhasil";
        $sess = $dt['sess'];

        $user = $this->bum->getById($b_user_id);
        if (!is_object($sess)) {
          $sess = new stdClass();
        }
        if (!isset($sess->user)) {
          $sess->user = new stdClass();
        }
        $sess->user = $user;
        $sess->user->menus = new stdClass();
        $sess->user->menus->left = array();

        $this->setKey($sess);
        $data['display_picture'] = $this->cdn_url($sc->image);
      }else{
        $this->status = 900;
        $this->message = "Gagal";
      }
    }else{
      $this->status = $sc->status;
      $this->message = $sc->message;
    }

    $this->__json_out($data);
  }
}