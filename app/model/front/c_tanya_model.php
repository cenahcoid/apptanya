<?php
// namespace Model\Front;

// register_namespace(__NAMESPACE__);
/**
* Scoped `front` model for `c_tanya` table
*
* @version 1.1.0
*
* @package Model\Front
* @since 1.0.0
*/
class C_Tanya_Model extends \JI_Model
{
	public $tbl = 'c_tanya';
	public $tbl_as = 'ct';
	public $tbl2 = 'b_user';
	public $tbl2_as = 'bu';

	public function __construct()
	{
		parent::__construct();
		$this->current_table('c_tanya');
		$this->current_table_alias('ct');
		$this->db->from($this->tbl, $this->tbl_as);
	}
	public function getAll()
	{
		$this->db->from($this->tbl, $this->tbl_as);
		return $this->db->get();
	}
	public function getById($id)
	{
		$this->db->where('id', $id);
		$this->db->from($this->tbl, $this->tbl_as);
		return $this->db->get_first();
	}
	public function set($di = array())
	{
		$this->db->insert($this->tbl, $di);
		return $this->db->last_id;
	}
	public function update($id, $du = array())
	{
		$this->db->where('id', $id);
		return $this->db->update($this->tbl, $du, 0);
	}
	public function del($id)
	{
		$this->db->where("id", $id);
		return $this->db->delete($this->tbl);
	}
	public function getCari($page = 0, $pagesize = 10, $sortCol = 'id', $sortDir = 'desc', $keyword = '')
	{
		$this->db->from($this->tbl, $this->tbl_as);
		if(strlen($keyword)) {
			$this->db->where('tanya', $keyword, 'or', '%like%', 1, 0);
			$this->db->where('jawab', $keyword, 'or', '%like%', 0, 1);
		}
		$this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
		return $this->db->get();
	}
	public function countCari($keyword = '')
	{
		$this->db->select_as("COUNT(*)", 'total', 0);
		$this->db->from($this->tbl, $this->tbl_as);
		if(strlen($keyword)) {
			$this->db->where('tanya', $keyword, 'or', '%like%', 1, 0);
			$this->db->where('jawab', $keyword, 'or', '%like%', 0, 1);
		}
		$d = $this->db->get_first();
		if(isset($d->total)) {
			return $d->total;
		}
		return 0;
	}

	public function all()
	{
	  $this->db->select_as("$this->tbl_as.rating, $this->tbl_as.jawaban_count, $this->tbl_as.tgl_tanya, $this->tbl_as.tanya, $this->tbl2_as.nama, $this->tbl2_as.display_picture, $this->tbl_as.id", 'id');
	  $this->db->from($this->tbl, $this->tbl_as);
	  $this->db->join($this->tbl2, $this->tbl2_as, 'id', $this->tbl_as, 'b_user_id_tanya', '');
	  $this->db->order_by("$this->tbl_as.tgl_tanya", 'desc');
	  return $this->db->get();
	}

	public function set_best_answer($id, $b_user_id_jawab, $jawab)
	{
		return $this->update($id, ['b_user_id_jawab' => $b_user_id_jawab, 'jawab' => $jawab]);
	}
}
