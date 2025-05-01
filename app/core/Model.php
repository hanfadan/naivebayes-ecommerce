<?php

class Model {
	protected $db;

    public function __construct() {
		$this->db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	}

    /*protected function delete($table)
    {
        return $this->db->delete($table);
    }*/

    protected function get($table, $limit = null, $select = '*')
    {
        return $this->db->get($table, $limit, $select);
    }

    protected function getInsertId()
    {
        return $this->db->getInsertId();
    }

    protected function getOne($table, $select = '*')
    {
        return $this->db->getOne($table, $select);
    }

    protected function getValue($table, $select, $limit = 1)
    {
        return $this->db->getValue($table, $select, $limit);
    }

    protected function like($name, $value = 'DBNULL')
    {
        $this->db->where($name, $value, 'LIKE');
        return $this;
    }

    protected function orWhere($name, $value = 'DBNULL', $operator = '=')
    {
        $this->db->orWhere($name, $value, $operator);
        return $this;
    }

    protected function where($name, $value = 'DBNULL', $operator = '=')
    {
        $this->db->where($name, $value, $operator);
        return $this;
    }

    protected function whereBetween($name, $value = 'DBNULL')
    {
        $this->db->where($name, $value, 'BETWEEN');
        return $this;
    }

    protected function whereIn($name, $value = 'DBNULL')
    {
        $this->db->where($name, $value, 'IN');
        return $this;
    }

    protected function whereNotBetween($name, $value = 'DBNULL')
    {
        $this->db->where($name, $value, 'NOT BETWEEN');
        return $this;
    }

    protected function whereNotIn($name, $value = 'DBNULL')
    {
        $this->db->where($name, $value, 'NOT IN');
        return $this;
    }
}