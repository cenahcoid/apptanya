<?php

class TanyaJawab extends \JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
        $this->load('front/b_user_model', 'bum');
        $this->load('front/c_tanya_model', 'ctm');
        $this->load('front/d_jawab_model', 'djm');
    }
    public function index()
    {
        $data = $this->initialize_data();

        if(!$this->user_login) {
            redir(base_url('login'));
            return false;
        }
        $this->setTitle('Buat pertanyaan baru atau jawab pertanyaan yang sudah ada '.$this->config_semevar('site_suffix', 'AppTanya'));
        $this->setDescription('Buat pertanyaan baru atau jawab pertanyaan yang sudah ada di '.$this->config->semevar->site_name);
        $this->setKeyword($this->config->semevar->site_name);
        $this->putThemeContent("tanyajawab/home", $data);
        $this->putJsContent("tanyajawab/home_bottom", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }
    public function detail($id)
    {
        $data = $this->initialize_data();

        if(!$this->user_login) {
            redir(base_url('login'));
            return false;
        }
        $id = (int) $id;
        if($id <= 0) {
            redir(base_url('notfound'));
            return false;
        }
        $data['data'] = $this->ctm->getById($id);
        if(!isset($data['data']->id)) {
            redir(base_url('notfound'));
            return false;
        }
        $data['data']->penanya = $this->bum->getById($data['data']->b_user_id_tanya);
        
        $data['data']->jawabans = $this->djm->c_tanya_id($id);

        $this->setTitle($data['data']->tanya.' '.$this->config_semevar('site_suffix', 'AppTanya'));
        $this->setDescription($data['data']->tanya.' via '.$this->config->semevar->site_name);
        $this->setKeyword($this->config->semevar->site_name);
        $this->putThemeContent("tanyajawab/detail", $data);
        $this->putJsContent("tanyajawab/detail_bottom", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }
}
