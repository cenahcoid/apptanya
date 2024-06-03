<?php

class B_user_Model extends \JI_Model
{
    public $tbl = 'b_user';
    public $tbl_as = 'bum';
    public function __construct()
    {
        parent::__construct();
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
        return $this->db->update($this->tbl, $du);
    }
    public function del($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete($this->tbl);
    }
    public function getByEmail($email = "")
    {
        $this->db->where("email", $email);
        return $this->db->get_first();
    }
}
