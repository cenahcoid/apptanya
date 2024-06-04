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
class Pertanyaan extends \JI_Controller
{
  public $evm_value;
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
    $this->load('front/b_user_model', 'bum');
    $this->load('front/c_tanya_model', 'ctm');
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

  private function validate($data, $id)
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

    return true;
  }
  
  private function check_already_vote($data, $id)
  {
    $this->evm_value = $this->evm->check_pertanyaan($id, $data['sess']->user->id);
    if (isset($this->evm_value->id)) {
      return true;
    }

    return false;
  }
  
  private function voting_save($data, $id, $nilai)
  {
    $di = array();
    $di['c_tanya_id'] = $id;
    $di['created_at'] = 'NOW()';
    $di['b_user_id'] = $data['sess']->user->id;
    $di['nilai'] = $nilai;

    return $this->evm->set($di);
  }
  
  private function voting_delete()
  {
    return $this->evm->del($this->evm_value->id);
  }
  
  private function calculate_rating($id)
  {
    $du = array();
    $du['rating'] = $this->evm->rating_pertanyaan($id);
    return $this->ctm->update($id, $du);
  }

  public function like($id)
  {
    $data = $this->initialize_data();
    $validation_result = $this->validate($data, $id);
    if (!$validation_result) {
      return $this->fallback_to_login();
    }

    $is_already_vote = $this->check_already_vote($data, $id);
    if ($is_already_vote) {
      redir(base_url('tanyajawab/detail/'.$id.'/?alreadyvote'));
      return false;
    }
    
    $res = $this->voting_save($data, $id, 1);
    if ($res) {
      $this->calculate_rating($id);
      redir(base_url('tanyajawab/detail/'.$id.'/?success'));
    } else {
      redir(base_url('tanyajawab/detail/'.$id.'/?failed'));
    }
  }

  public function dislike($id)
  {
    $data = $this->initialize_data();
    $validation_result = $this->validate($data, $id);
    if (!$validation_result) {
      return $this->fallback_to_login();
    }

    $is_already_vote = $this->check_already_vote($data, $id);
    if ($is_already_vote) {
      redir(base_url('tanyajawab/detail/'.$id.'/?alreadyvote'));
      return false;
    }
    
    $res = $this->voting_save($data, $id, -1);
    if ($res) {
      $this->calculate_rating($id);
      redir(base_url('tanyajawab/detail/'.$id.'/?dislike&success'));
    } else {
      redir(base_url('tanyajawab/detail/'.$id.'/?dislike&failed'));
    }
  }

  public function neutral($id)
  {
    $data = $this->initialize_data();
    $validation_result = $this->validate($data, $id);
    if (!$validation_result) {
      return $this->fallback_to_login();
    }

    $is_already_vote = $this->check_already_vote($data, $id);
    if (!$is_already_vote) {
      redir(base_url('tanyajawab/detail/'.$id.'/?alreadyvote'));
      return false;
    }
    
    $res = $this->voting_delete();
    if ($res) {
      $this->calculate_rating($id);
      redir(base_url('tanyajawab/detail/'.$id.'/?dislike&success'));
    } else {
      redir(base_url('tanyajawab/detail/'.$id.'/?dislike&failed'));
    }
  }
}
