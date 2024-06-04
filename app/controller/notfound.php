<?php
/**
 * Controller class for throw 404 response code
 *
 * @package SemeFramework
 * @since SemeFramework 1.0
 *
 * @codeCoverageIgnore
 */
class NotFound extends \JI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        header("HTTP/1.0 404 Not Found");
        $data = $this->__init();
        $this->setTitle('Error 404: Not Found '. $this->config_semevar('site_title_suffix', ''));
        $this->loadLayout("notfound",$data);
        $this->render();
    }
}
