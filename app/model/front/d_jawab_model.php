<?php
// namespace Model\Front;

// register_namespace(__NAMESPACE__);
/**
* Scoped `front` model for `d_jawab` table
*
* @version 1.1.0
*
* @package Model\Front
* @since 1.1.0
*/
class D_Jawab_Model extends \JI_Model
{
  public $tbl = 'd_jawab';
  public $tbl_as = 'dj';
  public $tbl2 = 'b_user';
  public $tbl2_as = 'bu';

  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
  }

  public function c_tanya_id($c_tanya_id)
  {
    $this->db->select_as("$this->tbl_as.*, $this->tbl2_as.nama", 'nama');
    $this->db->select_as("$this->tbl2_as.display_picture", 'display_picture');
    $this->db->join($this->tbl2, $this->tbl2_as, 'id', $this->tbl_as, 'b_user_id_jawab');
    $this->db->where_as('c_tanya_id', $c_tanya_id);
    $this->db->order_by('rating', 'desc');
    $this->db->order_by('created_at', 'desc');

    return $this->db->get();
  }
}
