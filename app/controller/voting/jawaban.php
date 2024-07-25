<?php
// namespace Controller;
// register_namespace(__NAMESPACE__);

/**
* Main Controller Class for rendering main page (onboarding)
*
* @version 1.0.0
*
* @package Controller\Voting
* @since 1.0.0
*/
class Jawaban extends \JI_Controller
{
  public $evm_value;
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
    $this->load('front/b_user_model', 'bum');
    $this->load('front/c_tanya_model', 'ctm');
    $this->load('front/d_jawab_model', 'djm');
    $this->load('front/d_notifikasi_model', 'dnm');
    $this->load('front/e_voting_model', 'evm');

    $this->evm_value = new \stdClass();
  }

  private function fallback_to_login()
  {
    redir(base_url());
    return false;
  }
  public function index()
  {
    redir(base_url());
  }

  private function validate($data, $id, $jawaban_id)
  {
    if (!$this->user_login) {
      return false;
    }

    $id = intval($id);
    if ($id<=0) {
      return false;
    }

    $ctm = $this->ctm->id($id);
    if (!isset($ctm->id)) {
      return false;
    }

    $djm = $this->djm->id($jawaban_id);
    if (!isset($djm->id)) {
      return false;
    }

    return true;
  }
  
  private function check_already_vote($data, $id, $jawaban_id)
  {
    $this->evm_value = $this->evm->check_jawaban($id, $jawaban_id, $data['sess']->user->id);
    if (isset($this->evm_value->id)) {
      return true;
    }

    return false;
  }

  private function set_best_answer($c_tanya_id)
  {
    $djm = new \stdClass();
    $best_answer = $this->evm->best($c_tanya_id);
    if (isset($best_answer->d_jawab_id)) {
      $djm = $this->djm->id($best_answer->d_jawab_id);
    }
    if (isset($djm->jawaban)) {
      $this->answer_got_voted($c_tanya_id, $djm->b_user_id_jawab);
      $this->ctm->set_best_answer($c_tanya_id, $djm->b_user_id_jawab, $djm->jawaban);
    }
  }
  
  private function voting_set($data, $c_tanya_id, $jawaban_id, $nilai)
  {
    $di = array();
    $di['c_tanya_id'] = $c_tanya_id;
    $di['d_jawab_id'] = $jawaban_id;
    $di['created_at'] = 'NOW()';
    $di['b_user_id'] = $data['sess']->user->id;
    $di['nilai'] = $nilai;

    return $this->evm->set($di);
  }

  private function answer_got_voted($c_tanya_id, $b_user_id_jawab)
  {
    $di = array();
    $di['b_user_id'] = $b_user_id_jawab;
    $di['c_tanya_id'] = $c_tanya_id;
    $di['isi'] = 'Ada yang voting jawaban kamu!';
    $di['is_read'] = 0;

    return $this->dnm->set($di);
  }

  private function answered_notification($c_tanya_id)
  {
    $ctm = $this->ctm->id($c_tanya_id);
    if (!isset($ctm->id)) {
      return false;
    }
    
    $di = array();
    $di['b_user_id'] = $ctm->b_user_id_tanya;
    $di['c_tanya_id'] = $c_tanya_id;
    $di['isi'] = 'Pertanyaan kamu udah ada yang jawab!';
    $di['is_read'] = 0;

    return $this->dnm->set($di);
  }
  
  private function voting_save($data, $c_tanya_id, $jawaban_id, $nilai)
  {
    $this->voting_set($data, $c_tanya_id, $jawaban_id, $nilai);
    $this->set_best_answer($c_tanya_id);
    $this->answered_notification($c_tanya_id);

    return true;
  }
  
  private function voting_delete()
  {
    return $this->evm->del($this->evm_value->id);
  }
  
  private function calculate_rating($id, $jawaban_id)
  {
    $du = array();
    $du['rating'] = $this->evm->rating_jawaban($id, $jawaban_id);
    $this->djm->update($jawaban_id, $du);
    
    $du['rating'] = $this->evm->rating_pertanyaan($id);
    return $this->ctm->update($id, $du);
  }

  public function like($id, $jawaban_id)
  {
    $data = $this->initialize_data();
    $validation_result = $this->validate($data, $id, $jawaban_id);
    if (!$validation_result) {
      return $this->fallback_to_login();
    }

    $is_already_vote = $this->check_already_vote($data, $id, $jawaban_id);
    if ($is_already_vote) {
      redir(base_url('tanyajawab/detail/'.$id.'/?alreadyvote'));
      return false;
    }
    
    $res = $this->voting_save($data, $id, $jawaban_id, 1);
    if ($res) {
      $this->calculate_rating($id, $jawaban_id);
      redir(base_url('tanyajawab/detail/'.$id.'/?success'));
    } else {
      redir(base_url('tanyajawab/detail/'.$id.'/?failed'));
    }
  }

  public function dislike($id, $jawaban_id)
  {
    $data = $this->initialize_data();
    $validation_result = $this->validate($data, $id, $jawaban_id);
    if (!$validation_result) {
      return $this->fallback_to_login();
    }

    $is_already_vote = $this->check_already_vote($data, $id, $jawaban_id);
    if ($is_already_vote) {
      redir(base_url('tanyajawab/detail/'.$id.'/?alreadyvote'));
      return false;
    }
    
    $res = $this->voting_save($data, $id, $jawaban_id, -1);
    if ($res) {
      $this->calculate_rating($id, $jawaban_id);
      redir(base_url('tanyajawab/detail/'.$id.'/?dislike&success'));
    } else {
      redir(base_url('tanyajawab/detail/'.$id.'/?dislike&failed'));
    }
  }

  public function neutral($id, $jawaban_id)
  {
    $data = $this->initialize_data();
    $validation_result = $this->validate($data, $id, $jawaban_id);
    if (!$validation_result) {
      return $this->fallback_to_login();
    }

    $is_already_vote = $this->check_already_vote($data, $id, $jawaban_id);
    if (!$is_already_vote) {
      redir(base_url('tanyajawab/detail/'.$id.'/?notvotedyet'));
      return false;
    }
    
    $res = $this->voting_delete();
    if ($res) {
      $this->calculate_rating($id, $jawaban_id);
      redir(base_url('tanyajawab/detail/'.$id.'/?dislike&success'));
    } else {
      redir(base_url('tanyajawab/detail/'.$id.'/?dislike&failed'));
    }
  }
}
