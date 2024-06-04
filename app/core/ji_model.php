<?php
class JI_Model extends \SENE_Model
{
  public $tbl;
  public $tbl_as;

  public function __construct()
  {
    parent::__construct();
  }

  protected function current_table($table_name='')
  {
    if (strlen($table_name)) {
      $this->tbl = $table_name;
    }

    return $this->tbl;
  }

  protected function current_table_alias($table_alias_name='')
  {
    if (strlen($table_alias_name)) {
      $this->tbl_as = $table_alias_name;
    }
    
    return $this->tbl_as;
  }

  public function trans_start()
  {
    $r = $this->db->autocommit(0);
    if ($r) {
      return $this->db->begin();
    }
    return false;
  }

  public function trans_commit()
  {
    return $this->db->commit();
  }

  public function trans_rollback()
  {
    return $this->db->rollback();
  }

  public function trans_end()
  {
    return $this->db->autocommit(1);
  }

  public function set($di=array())
  {
    $this->db->flushQuery();
    $this->db->insert($this->current_table(), $di, 0, 0);
    return $this->db->lastId();
  }

	public function setMass($dis)
	{
		return $this->db->insert_multi($this->current_table(), $dis, 0);
	}

  public function update($id, $du)
  {
    if (!is_array($du)) {
      return 0;
    }
    $this->db->where("id", $id);
    return $this->db->update($this->current_table(), $du, 0);
  }
  public function del($id)
  {
    $this->db->where("id", $id);
    return $this->db->delete($this->current_table());
  }
  public function id($id)
  {
    $this->db->where("id", $id);
    return $this->db->get_first();
  }
}
