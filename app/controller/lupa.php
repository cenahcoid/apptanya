<?php
class Lupa extends JI_Controller
{
  public $email_send = 1;
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
    $this->load('front/b_user_model','bum');
  }

  private function __passGen($password){
    $password = preg_replace('/[^a-zA-Z0-9]/', '', $password);
    return password_hash($password, PASSWORD_BCRYPT);
  }

  private function __passClear($password){
    return preg_replace('/[^a-zA-Z0-9]/', '', $password);
  }
  private function __genTokenMobile($user_id)
  {
    $user_id = (int) $user_id;
    $this->lib("conumtext");
    $token = '';
    if ($user_id == 3) {
      $token = 'KMZDT';
    } elseif ($user_id == 2) {
      $token = 'KMZDR';
    } elseif ($user_id == 1) {
      $token = 'KMZDS';
    } elseif ($user_id == 4) {
      $token = 'KMZDU';
    } elseif ($user_id == 24783) {
      $token = 'KMZDA';
    } else {
      $token = $this->conumtext->genRand($type="str", $min=7, $max=11);
    }
    return $token;
  }

  private function __passwordGenerateLink($b_user_id){
    $this->lib("conumtext");
    $token = $this->conumtext->genRand($type="str", $min=18, $max=24);
    $this->bum->setToken($b_user_id, $token, $kind="api_web");
    return base_url('akun/password/reset/'.$token);
  }
  public function index()
  {
    $data = array();
    $data = $this->initialize_data();
    $this->setTitle('Lupa - '.$this->config->semevar->site_name);
    $this->setDescription("Halaman Lupa ".$this->config->semevar->site_name);
    $this->setKeyword('lupa');

    $this->putThemeContent("lupa/home",$data); //pass data to view
    $this->putJsContent("lupa/home_bottom",$data); //pass data to view

    $this->loadLayout("col-1",$data);
    $this->render();
  }
  public function proses(){
    //init
    $data = array();
    $dt = $this->initialize_data();
    if($this->user_login){
      $this->status = 401;
      $this->message = 'Sudah Login';
      $this->__json_out($data);
      return false;
    }
    $email = $this->input->request('email');
    if (strlen($email)<= 4){
      $this->status = 504;
      $this->message = 'Email tidak valid atau terlalu pendek';
      $this->__json_out($data);
      return false;
    }

    $user = $this->bum->getByEmail($email);
    if(isset($user->id)){
      if(empty($user->is_active)){
        $this->status = 606;
        $this->message = 'Pengguna dengan email ini telah dinonaktifkan';
        $this->__json_out($data);
        return false;
      }
      if ($this->email_send) {
        $link = $this->__passwordGenerateLink($user->id);
        $this->lib('seme_email');

        $replacer = array();
        $replacer['fnama'] = $user->nama;
        $replacer['site_name'] = $this->config->semevar->site_name;
        $replacer['site_name1'] = $this->config->semevar->site_name;
        $replacer['reset_link'] = $link;

        $this->seme_email->flush();
        $this->seme_email->replyto($this->config->semevar->site_name, $this->config->semevar->email_reply);
        $this->seme_email->from($this->config->semevar->email_from, $this->config->semevar->site_name);
        $this->seme_email->subject('Forgot Password');
        $this->seme_email->to($user->email, $user->nama);
        $this->seme_email->template('account_forgot');
        $this->seme_email->replacer($replacer);
        $this->seme_email->send();
      }
      $this->status = 200;
      $this->message = 'Success, please check your email if you are registered';
    }else{
      $this->status = 505;
      $this->message = 'Email belum terdaftar';
      $this->__json_out($data);
      return false;
    }

    $this->__json_out($data);
  }
}
