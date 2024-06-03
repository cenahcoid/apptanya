<?php
class Ganti extends JI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
  }
  public function index()
  {
    $data = $this->__init();

    if(!$this->user_login){
      redir(base_url('login'));
      return false;
    }

    $this->setTitle('Ganti '.$this->config_semevar('site_suffix', 'AppTanya'));
    $this->setDescription("Silakan login untuk bisa bertanya atau menjawab di ".$this->config->semevar->site_name);
    $this->setKeyword('Ganti');

    $this->putThemeContent("ganti/home",$data); //pass data to view
    $this->putJsContent("ganti/home_bottom",$data); //pass data to view

    $this->loadLayout("col-1",$data);
    $this->render();
  }
}
