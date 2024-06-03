<?php
// namespace Model\Front\API;

// register_namespace(__NAMESPACE__);
/**
* Scoped `front` model for `d_jawab` table
*
* @version 1.1.0
*
* @package Model\Front\API
* @since 1.1.0
*/
class D_Jawab_Model extends \JI_Model
{
  public $tbl = 'd_jawab';
  public $tbl_as = 'dj';

  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
  }

  public function c_tanya_id($c_tanya_id)
  {
    $this->db->where('c_tanya_id', $c_tanya_id);
    $this->db->order_by('rating', 'desc');
    $this->db->order_by('created_at', 'desc');

    return $this->db->get();
  }

  public function already_answered($c_tanya_id, $b_user_id_jawab)
  {
    $this->db->where('c_tanya_id', $c_tanya_id);
    $this->db->where('b_user_id_jawab', $b_user_id_jawab);
    return $this->db->get_first();
  }
}
