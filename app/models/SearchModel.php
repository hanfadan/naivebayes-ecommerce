<?php

class SearchModel extends Model {
    public function findAll(){
        $this->db->orderBy('view', 'Desc');
        return $this->db->get('searchs');
	}

    public function findByName($val){
        return $this->db->where('name', $val)->getOne('searchs');
	}

    public function insert($data){
        return $this->db->insert('searchs', $data);
	}

    public function update($id, $data){
        return $this->db->where('id', $id)->update('searchs', $data);
	}
}