<?php

class Jawab extends \JI_Controller
{
    public $email_send = 0;
    public $is_log = 0;
    public function __construct()
    {
        parent::__construct();
        $this->lib("seme_email");
        //$this->lib("seme_log");
        $this->load("api_web/b_user_model", 'bum');
        $this->load("api_web/c_tanya_model", 'ctm');
        $this->load("api_web/d_jawab_model", 'djm');
        $this->load("api_web/d_notifikasi_model", 'dnm');
    }
    public function index()
    {
        $data = array();
        $this->status = 404;
        $this->message = "Not found";
        $this->__json_out($data);
    }
    public function pertanyaan($id)
    {
        $session = $this->initialize_data();
        $data = array();

        if(!$this->user_login) {
            $this->status = 403;
            $this->message = "Harus login";
            $this->__json_out($data);
            return false;
        }

        $id = (int) $id;
        if($id <= 0) {
            $this->status = 550;
            $this->message = "ID tidak valid";
            $this->__json_out($data);
            return false;
        }
        $data['data'] = $this->ctm->getById($id);
        if(!isset($data['data']->id)) {
            $this->status = 551;
            $this->message = "Data dengan ID '".$id."' tidak ditemukan";
            $this->__json_out($data);
            return false;
        }
        
        $already_answered = $this->djm->already_answered($id, $session['sess']->user->id);
        if (isset($already_answered->id)) {
            $this->status = 552;
            $this->message = "Pertanyaan ini telah anda dijawab";
            $this->__json_out($data);
            return false;
        }

        $di = array();
        $di['c_tanya_id'] = $id;
        $di['b_user_id_jawab'] = $session['sess']->user->id;
        $di['created_at'] = 'NOW()';
        $di['jawaban'] = strip_tags(trim($this->input->post('jawab')));
        if(strlen($di['jawaban']) <= 2) {
            $this->status = 553;
            $this->message = "jawaban terlalu pendek";
            $this->__json_out($data);
            return false;
        }

        $res = $this->djm->set($di);
        if($res) {
            $this->status = 200;
            $this->message = "Jawaban berhasil disimpan ke database";
            $this->update_jawaban_count($id);
            $this->create_notification($session, $id, $data);
        } else {
            $this->status = 554;
            $this->message = "Gagal menyimpan jawaban ke database";
        }

        $this->__json_out($data);
    }

    private function create_notification($session, $id, $data)
    {
      $di = array();
      $di['b_user_id'] = $session['sess']->user->id;
      $di['c_tanya_id'] = $id;
      $di['isi'] = 'Telah dijawab! "'.$data['data']->tanya.'"';
      $di['is_read'] = 0;

      return $this->dnm->set($di);
    }

    private function update_jawaban_count($id)
    {
      $du = array();
      $du['jawaban_count'] = $this->djm->count_jumlah_jawaban($id);
      return $this->ctm->update($id, $du);
    }
}
