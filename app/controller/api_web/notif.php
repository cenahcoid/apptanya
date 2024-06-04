<?php
class Notif extends JI_Controller
{
  public $email_send = 0;
  public $is_log = 0;
  public function __construct()
  {
    parent::__construct();
    $this->lib("seme_email");
    $this->load("api_web/d_notifikasi_model",'dnm');
  }
  public function index(){
    $data = array();
    $this->status = 404;
    $this->message = "Not found";
    $this->__json_out($data);
  }
  public function count(){
    $s = $this->initialize_data();
    $data = 0;

    if(!$this->user_login){
      $this->status = 403;
      $this->message = "Harus login";
      $this->__json_out($data);
      return false;
    }

    $this->status = 200;
    $this->message = "Berhasil";
    $data = (int) $this->dnm->countByUserId($s['sess']->user->id,0);

    $this->__json_out($data);
  }
}
