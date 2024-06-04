<?php
// namespace Controller;
// register_namespace(__NAMESPACE__);

/**
* Main Controller Class for rendering main page (onboarding)
*
* @version 1.0.0
*
* @package Controller
* @since 1.0.0
*/
class Profil extends JI_Controller
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

    $this->setTitle('Profil - '.$this->config->semevar->site_name);
    $this->setDescription("Halaman Profil ".$this->config->semevar->site_name);
    $this->setKeyword('Profil');

    $this->putThemeContent("profil/home",$data); //pass data to view
    $this->putJsContent("profil/home_bottom",$data); //pass data to view
    $this->loadLayout("col-1",$data);
    $this->render();
  }
  
  public function edit()
  {
    $data = array();
    $data = $this->initialize_data();

    if(!$this->user_login){
      redir(base_url('login'));
      return false;
    }

    $this->setTitle('Edit Profil - '.$this->config->semevar->site_name);
    $this->setDescription("Halaman Edit Profil ".$this->config->semevar->site_name);
    $this->setKeyword('Profil');

    $this->putThemeContent("profil/edit",$data); //pass data to view
    $this->putJsContent("profil/edit_bottom",$data); //pass data to view
    $this->loadLayout("col-1",$data);
    $this->render();
  }

  public function ganti_password()
  {
    $data = $this->initialize_data();

    if(!$this->user_login){
      redir(base_url('login'));
      return false;
    }

    $this->setTitle('Ganti Password'.$this->config_semevar('site_suffix', 'AppTanya'));
    $this->setDescription("Halaman untuk mengganti password ".$this->config->semevar->site_name);
    $this->setKeyword('Ganti');

    $this->putThemeContent("profil/ganti_password",$data); //pass data to view
    $this->putJsContent("profil/ganti_password_bottom",$data); //pass data to view

    $this->loadLayout("col-1",$data);
    $this->render();
  }
}
