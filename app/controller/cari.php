<?php
class Cari extends JI_Controller{

	public function __construct(){
    parent::__construct();
		$this->setTheme('front');
		$this->load('front/c_tanya_model','ctm');
	}
	public function index(){
		$data = $this->__init();
		$keyword = strip_tags(trim($this->input->get('keyword')));

		if(strlen($keyword)>1){
			$page = (int) $this->input->get('page');
			if($page<=0){
				$page = 1;
			}

			$pagesize = (int) $this->input->get('pagesize');
			if($pagesize!=10){
				$pagesize = 10;
			}

			$this->setTitle('Hasil pencarian "'.$keyword.'" '.$this->config_semevar('site_suffix', 'AppTanya'));
			$this->setDescription('Hasil pencarian "'.$keyword.'" di '.$this->config->semevar->site_name);
			$data['data'] = $this->ctm->getCari(0,10,'id','desc',$keyword);
			$data['count'] = $this->ctm->countCari($keyword);
			$data['page'] = $page;
			$data['pagesize'] = $pagesize;
			$data['keyword'] = $keyword;
			$this->putThemeContent("cari/hasil",$data);
			$this->putJsContent("cari/hasil_bottom",$data);
		}else{
			$this->setTitle('Cari pertanyaan atau jawaban '.$this->config_semevar('site_suffix', 'AppTanya'));
			$this->setDescription('Cari pertanyaan atau jawaban di '.$this->config->semevar->site_name);
			$this->putThemeContent("cari/home",$data);
			$this->putJsContent("cari/home_bottom",$data);
		}
		$this->setKeyword($this->config->semevar->site_name);
		$this->loadLayout("col-1",$data);
		$this->render();
	}
}
