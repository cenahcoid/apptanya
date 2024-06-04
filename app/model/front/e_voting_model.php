<?php

// namespace Model\Front;

// register_namespace(__NAMESPACE__);
/**
* Scoped `front` model for `e_voting` table
*
* @version 1.1.0
*
* @package Model\Front
* @since 1.1.0
*/
class E_Voting_Model extends \JI_Model
{
    public $tbl = 'e_voting';
    public $tbl_as = 'ev';

    public function __construct()
    {
        parent::__construct();
        $this->current_table('e_voting');
        $this->current_table_alias('ev');
        $this->db->from($this->tbl, $this->tbl_as);
    }

    public function check_pertanyaan($c_tanya_id, $b_user_id)
    {
        $this->db->where("c_tanya_id", $c_tanya_id);
        $this->db->where("d_jawab_id", 'is NULL');
        $this->db->where("b_user_id", $b_user_id);

        return $this->db->get_first('', 0);
    }

    public function check_jawaban($c_tanya_id, $d_jawab_id, $b_user_id)
    {
        $this->db->where("c_tanya_id", $c_tanya_id);
        $this->db->where("d_jawab_id", $d_jawab_id);
        $this->db->where("b_user_id", $b_user_id);

        return $this->db->get_first();
    }

    public function rating_pertanyaan($c_tanya_id)
    {
        $this->db->select_as("coalesce(sum(nilai), 0)", 'rating');
        $this->db->where("c_tanya_id", $c_tanya_id);
        $d = $this->db->get_first('', 0);
        if (isset($d->rating)) {
          return intval($d->rating);
        }
        return 0;
    }

    public function rating_jawaban($c_tanya_id, $d_jawab_id)
    {
        $this->db->select_as("coalesce(sum(nilai), 0)", 'rating');
        $this->db->where("c_tanya_id", $c_tanya_id);
        $this->db->where("d_jawab_id", $d_jawab_id);
        $d = $this->db->get_first();
        if (isset($d->rating)) {
          return intval($d->rating);
        }
        return 0;
    }
}
