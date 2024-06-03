<?php
class User extends JI_Controller
{
  public $email_send = 0;
  public $is_log = 0;
  public function __construct()
  {
    parent::__construct();
    $this->lib("seme_email");
    //$this->lib("seme_log");
    $this->load("api_web/b_user_model",'bum');
  }
  private function __genRegKode($user_id, $api_reg_token)
  {
    if (strlen($api_reg_token)>5 && strlen($api_reg_token)<=7) {
      return $api_reg_token;
    } else {
      $this->lib("conumtext");
      $token = $this->conumtext->genRand($type="str", 5, 5);
      $this->bum->setToken($user_id, $token, $kind="api_reg");
      return $token;
    }
  }
  public function index()
  {
    $d = $this->__init();
    $data = array();
    if(!$this->user_login){
      $this->status = 400;
      $this->message = "Harus Login";
      $this->__json_out($data);
      return false;
    }

    $this->status = 200;
    $this->message= 'Berhasil';

    $this->__json_out($data);
  }
  public function daftar(){
    $d = $this->__init();
    $data = array();

    if($this->user_login){
      $this->status = 400;
      $this->message = "Sudah Login";
      redir(base_url("bimbingan"));
    }

    $di = $_POST;

    if(!isset($di['email'])) $di['email'] = '';
    if(!isset($di['nama'])) $di['nama'] = '';
    if(!isset($di['alamat'])) $di['alamat'] = '';

    $di['email'] = strip_tags(trim($di['email']));
    $di['nama'] = strip_tags(trim($di['nama']));
    $di['alamat'] = strip_tags(trim($di['alamat']));

    if(strlen($di['email']) <= 4 || strlen($di['nama']) <= 1){
      $this->status = 401;
      $this->message = 'Salah satu parameter belum diisi';
      $this->__json_out($data);
      return false;
    }

    $user = $this->bum->getByEmail($di['email']);
    if(isset($user->id)){
      $this->status = 402;
      $this->message = 'Email sudah digunakan. Silakan untuk login';
      $this->__json_out($data);
      return false;
    }

    if(strlen($di['password']) < 6){
      $this->status = 402;
      $this->message = 'Min. 6 Karakter, mengandung huruf dan angka';
      $this->__json_out($data);
      return false;
    }

    $di['password'] = md5($di['password']);

    $res = $this->bum->set($di);
    if($res){
      $this->status = 200;
      $this->message = 'Berhasil';

      //auto login if preferred
      if ($this->is_auto_login_after_register()) {
        $user = $this->bum->getByEmail($di['email']);
        
        //add to session
        $sess = $d['sess'];
        if(!is_object($sess)) $sess = new stdClass();
        if(!isset($sess->user)) $sess->user = new stdClass();
        $sess->user = $user;

        $this->setKey($sess);
      }
    }else{
      $this->status = 900;
      $this->message = 'Gagal';
    }
    $this->__json_out($data);
  }

  public function login(){
    $d = $this->__init();

    $data = array();
    if($this->user_login){
      $this->status = 808;
      $this->message = "Sudah Login";
      $this->__json_out($data);
      return false;
    }

    $email = $this->input->post("email");
    $password = $this->input->post("password");

    $user = $this->bum->getByEmail($email);
    if(isset($user->id)){

      if(md5($password) == $user->password){
        $user->password = password_hash($password,PASSWORD_BCRYPT);
      }else{
        $this->status = 1707;
        $this->message = 'Invalid email or password';
        $this->__json_out($data);
        return false;
      }

      if(!password_verify($password, $user->password)){
        $this->status = 1707;
        $this->message = 'Invalid email or password';
        $this->__json_out($data);
        return false;
      }
    }else{
      $this->status = 1708;
      $this->message = 'Email belum terdaftar. Silakan daftar terlebih dahulu';
      $this->__json_out($data);
      return false;
    }

    if ($this->email_send && strlen($user->email)>4 && empty($user->is_confirmed)) {
      if (strlen($user->fb_id)<=1 && strlen($user->google_id)<=1) {
        $link = $this->__genRegKode($user->id, $user->api_reg_token);
        $email = $user->email;
        $nama = $user->fnama;
        $replacer = array();
        $replacer['site_name'] = $this->app_name;
        $replacer['fnama'] = $nama;
        $replacer['activation_link'] = $link;
        $this->seme_email->flush();
        $this->seme_email->replyto($this->app_name, $this->site_replyto);
        $this->seme_email->from($this->site_email, $this->app_name);
        $this->seme_email->subject('Verifikasi Ulang Email');
        $this->seme_email->to($email, $nama);
        $this->seme_email->template('account_verification');
        $this->seme_email->replacer($replacer);
        $this->seme_email->send();
        if ($this->is_log) {
          $this->seme_log->write("API_Mobile/Pelanggan::index --userID: $user->id --unconfirmedEmail: $user->email");
        }
      }
    }

    //add to session
    $sess = $d['sess'];
    if(!is_object($sess)) $sess = new stdClass();
    if(!isset($sess->user)) $sess->user = new stdClass();
    $sess->user = $user;

    $this->setKey($sess);

    $this->status = 200;
    $this->message = 'Berhasil';
    $this->__json_out($data);
  }

  public function edit(){
    $d = $this->__init();
    $data = array();

    if(!$this->user_login){
      $this->status = 400;
      $this->message = "Belum Login";
      $this->__json_out($data);
      return false;
    }

    $nama = $this->input->post("nama");
    if(empty($nama)) $nama = '';
    $nama = strip_tags(trim($nama));

    $email = $this->input->post("email");
    if(strlen($email)<=1){
      $this->status = 590;
      $this->message = "Email tidak valid";
      $this->__json_out($data);
      return false;
    }

    $jk = $this->input->post("jk");
    if(empty($jk)) $jk = 'NULL';

    $alamat = $this->input->post("alamat");
    if(empty($alamat)) $alamat = 'NULL';
    $alamat = strip_tags(trim($alamat));

    $email = $this->input->post("email");
    if(empty($email)) $email = '';
    $email = strip_tags(trim($email));

    if(strlen($email)<=4){
      $this->status = 591;
      $this->message = "Email tidak valid";
      $this->__json_out($data);
      return false;
    }

    $bum = $this->bum->getByEmail($email);
    if(isset($bum->email) && $email != $d['sess']->user->email){
      $this->status = 691;
      $this->message = "Email sudah digunakan";
      $this->__json_out($data);
      return false;
    }

    $id = $d['sess']->user->id;

    $du = array();
    $du['nama'] = $nama;
    $du['email'] = $email;
    $du['jk'] = $jk;
    $du['alamat'] = $alamat;

    $res = $this->bum->update($id, $du);
    if($res){
      $this->status = 200;
      $this->message = 'Berhasil';

      //add to session
      $d['sess']->user->nama = $nama;
      $d['sess']->user->alamat = $alamat;
      $d['sess']->user->jk = $jk;
      $d['sess']->user->email = $email;

      $sess = $d['sess'];
      if(!is_object($sess)) $sess = new stdClass();
      if(!isset($sess->user)) $sess->user = new stdClass();

      $this->setKey($sess);
    }else{
      $this->status = 900;
      $this->message = 'Gagal';
    }

    $this->__json_out($data);
  }

  public function logout(){
    $data = $this->__init();
    if(isset($data['sess']->user->id)){
      $user = $data['sess']->user;
      //$this->seme_chat->set_offline($user->id);
      $sess = $data['sess'];
      $sess->user = new stdClass();
      $this->user_login = 0;
      $this->setKey($sess);
    }
    //sleep(1);
    //ob_clean();
    flush();
    redir(base_url(""),0,1);
    //redir(base_url_admin("login"),0,0);
  }
  /**
  * Bypass verification
  * @return [type] [description]
  */
  public function bp(){
    $data = $this->__init();
    if(isset($data['sess']->user->id)){
      $data['sess']->user->is_confirmed = 1;
      $this->setKey($data['sess']);
    }
    $this->status = 200;
    $this->message = 'Berhasil';
    $this->__json_out($data);
  }

  public function password_ganti()
  {
    $d = $this->__init();
    $data = array();
    if (!$this->user_login) {
      $this->status = 400;
      $this->message = 'Harus login';
      header("HTTP/1.0 400 Harus login");
      $this->__json_out($data);
      return false;
    }

    $du = $_POST;
    foreach($du as $k=>$v){
      $du[$k] = strip_tags($v);
    }

    $user = $this->bum->getById($d['sess']->user->id);
    if (!isset($user->id)) {
      $this->status = 426;
      $this->message = 'User with supplied ID not found';
      $this->__json_out($data);
      return false;
    }

    $password_lama = $this->input->post('password_lama');
    if (!isset($password_lama)) {
      $password_lama = "";
    }

    $password_baru = $this->input->post('password_baru');
    if (!isset($password_baru)) {
      $password_baru = "";
    }

    if(md5($password_lama) == $d['sess']->user->password) $d['sess']->user->password = password_hash($password, PASSWORD_BCRYPT);


    if(!password_verify($password_lama, $d['sess']->user->password)){
      $this->status = 601;
      $this->message = 'Password lama salah';
      $this->__json_out($data);
      return false;
    }

    if(strlen($password_baru)<=4){
      $this->status = 427;
      $this->message = 'Password baru terlalu pendek';
      $this->__json_out($data);
      return false;
    }

    $res = $this->bum->update($d['sess']->user->id, array('password'=>md5($password_baru)));
    if ($res) {
      $this->status = 200;
      $this->message = 'Perubahan berhasil diterapkan';
    } else {
      $this->status = 901;
      $this->message = 'Tidak dapat melakukan perubahan ke basis data';
    }
    $this->__json_out($data);
  }
}
