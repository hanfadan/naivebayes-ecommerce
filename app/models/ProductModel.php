<?php

class ProductModel extends Model {
    public function delete($id) {
        return $this->db->where('id', $id)->delete('products');
    }

    public function findAll(){
        $this->db->join('categories b', 'a.category_id = b.id', 'LEFT');
        return $this->db->get('products a', null, 'a.*, b.name as category');
	}

    public function findHome($search, $category){
		$like = '';
		$where = '';

        if (!empty($search)) {
			$like = " WHERE a.name LIKE '%$search%'";
        }
        
        if (!empty($category)) {
			$where = " AND b.slug = '$category'";
        }

		$query = 'SELECT a.*, b.name as category FROM products a LEFT JOIN categories b ON a.category_id = b.id'.$like.$where;

		return $this->db->rawQuery($query);
	}

    public function findLast($count = null){
        $this->db->join('categories b', 'a.category_id = b.id', 'LEFT');
        return $this->db->orderBy('id', 'desc')->get('products a', $count, 'a.*, b.name as category');
	}

    public function findOne($id){
        return $this->db->where('id', $id)->getOne('products');
	}

    public function findWhere($key, $val){
        return $this->db->where($key, $val)->get('products');
	}

    public function insert($data){
        return $this->db->insert('products', $data);
	}

    public function update($id, $data){
        return $this->db->where('id', $id)->update('products', $data);
	}
}