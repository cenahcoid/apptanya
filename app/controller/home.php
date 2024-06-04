<?php

// namespace Controller;
// register_namespace(__NAMESPACE__);

/**
* Main Controller Class for rendering main page (onboarding)
*
* @version 1.0.0
*
* @package Onboarding\Controller
* @since 1.0.0
*/
class Home extends \JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
    }
    public function index()
    {
        $data = $this->initialize_data();
        if ($this->user_login) {
            redir(base_url('dashboard'));
            return false;
        }
        $this->setTitle('Selamat datang di '.$this->config->semevar->site_name);
        $this->setDescription($this->config->semevar->site_name.' merupakan aplikasi berbasis web untuk melakukan tanya jawab seputar pertanyaan sehari-hari');
        $this->setKeyword($this->config->semevar->site_name);
        $this->putThemeContent("home/home", $data);
        $this->putJsContent("home/home_bottom", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }
}
