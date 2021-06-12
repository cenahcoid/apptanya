<?php
class Daftar extends JI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
  }
  public function index()
  {
    $data = $this->__init();

    if($this->user_login){
      redir(base_url('profil'));
      die();
    }

    $this->setTitle('Daftar '.$this->config->semevar->site_suffix);
    $this->setDescription("Daftarkan diri anda untuk dapat bertanya atau menjawab ".$this->config->semevar->site_name);
    $this->setKeyword('Daftar');

    $this->putThemeContent("daftar/home",$data); //pass data to view
    $this->putJsContent("daftar/home_bottom",$data); //pass data to view
    $this->loadLayout("col-1",$data);
    $this->render();
  }
}
