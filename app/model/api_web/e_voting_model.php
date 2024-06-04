<?php
// namespace Model\Front\API;

// register_namespace(__NAMESPACE__);
/**
* Scoped `front` model for `e_voting` table
*
* @version 1.1.0
*
* @package Model\Front\API
* @since 1.1.0
*/
class E_Voting_Model extends \JI_Model
{
  public $tbl = 'e_voting';
  public $tbl_as = 'ev';

  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
  }
}