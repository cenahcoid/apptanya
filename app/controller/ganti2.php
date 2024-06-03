<?php
class Ganti2 extends JI_Controller
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
      die();
    }

    $this->setTitle('Ganti2 '.$this->config_semevar('site_suffix', 'AppTanya'));
    $this->setDescription("Silakan login untuk bisa bertanya atau menjawab di ".$this->config->semevar->site_name);
    $this->setKeyword('Ganti2');

    $this->putThemeContent("ganti2/home",$data); //pass data to view
    $this->putJsContent("ganti2/home_bottom",$data); //pass data to view

    $this->loadLayout("col-1",$data);
    $this->render();
  }
}
