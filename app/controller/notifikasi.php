<?php
class Notifikasi extends JI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
    $this->load('front/d_notifikasi_model',"dnm");
  }
  public function index()
  {
    $data = array();
    $data = $this->initialize_data();

    if(!$this->user_login){
      redir(base_url('login'));
      return;
    }

    $data['data'] = $this->dnm->getByUserId($data['sess']->user->id);
    $data['count'] = $this->dnm->countByUserId($data['sess']->user->id);

    $this->setTitle('Notifikasi - '.$this->config->semevar->site_name);
    $this->setDescription("Halaman Notifikasi ".$this->config->semevar->site_name);
    $this->setKeyword('Notifikasi');

    $this->putThemeContent("notifikasi/home",$data); //pass data to view
    $this->putJsContent("notifikasi/home_bottom",$data); //pass data to view
    $this->loadLayout("col-1",$data);
    $this->render();
  }
  public function baca($id)
  {
    $data = array();
    $data = $this->initialize_data();

    if(!$this->user_login){
      redir(base_url('login'));
      return;
    }
    $id = (int) $id;
    if($id<=0){
      redir(base_url('notfound'));
      return;
    }
    $data['data'] = $this->dnm->getById($id);
    if(!isset($data['data']->id)){
      redir(base_url('notfound'));
      return;
    }
    $du = array('is_read'=>1);
    $this->dnm->update($id,$du);
    redir(base_url('tanyajawab/detail/'.$data['data']->c_tanya_id.'/'));
    return;
  }
}
