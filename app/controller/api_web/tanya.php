<?php
class Tanya extends JI_Controller
{
  public $email_send = 0;
  public $is_log = 0;
  public function __construct()
  {
    parent::__construct();
    $this->lib("seme_email");
    //$this->lib("seme_log");
    $this->load("api_web/b_user_model",'bum');
    $this->load("api_web/c_tanya_model",'ctm');
  }
  public function index(){
    $data = array();
    $this->status = 404;
    $this->message = "Not found";
    $this->__json_out($data);
  }
  public function baru(){
    $s = $this->initialize_data();
    $data = array();
    $data['id'] = 0;

    if(!$this->user_login){
      $this->status = 403;
      $this->message = "Harus login";
      $this->__json_out($data);
      return false;
    }

    $di = array();
    $di['b_user_id_tanya'] = $s['sess']->user->id;
    $di['tanya'] = strip_tags(trim($this->input->post('tanya')));
    $di['tgl_tanya'] = 'NOW()';
    $di['jawab'] = '';
    $du['tgl_jawab'] = 'NOW()';
    if(strlen($di['tanya'])<=2){
      $this->status = 540;
      $this->message = "Pertanyaan terlalu pendek";
      $this->__json_out($data);
      return false;
    }

    $res = $this->ctm->set($di);
    if($res){
      $this->status = 200;
      $this->message = "Pertanyaan berhasil disimpan ke database";
      $data['id'] = (int) $res;
    }else{
      $this->status = 541;
      $this->message = "Gagal menyimpan pertanyaan ke database";
    }

    $this->__json_out($data);
  }
}
