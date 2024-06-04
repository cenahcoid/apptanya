<?php
class Dashboard extends JI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
    $this->load('front/b_user_model',"bum");
  }
  public function index()

  {
    $data = array();
    $data = $this->initialize_data();

    if(!$this->user_login){
      redir(base_url('login'));
      return false;
    }

    $this->setTitle('Dashboard - '.$this->config->semevar->site_name);
    $this->setDescription("Halaman Dashboard ".$this->config->semevar->site_name);
    $this->setKeyword('Dashboard');

    $this->putThemeContent("dashboard/home",$data); //pass data to view
    $this->putJsContent("dashboard/home_bottom",$data); //pass data to view
    $this->loadLayout("col-1",$data);
    $this->render();
  }
}
