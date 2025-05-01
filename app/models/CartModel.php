<?php

class CartModel extends Model {
    public function delete($id) {
        return $this->db->where('id', $id)->delete('carts');
    }

    public function findAll($user){
        $this->db->join('products c', 'a.product_id = c.id', 'LEFT');
        $this->db->join('categories b', 'c.category_id = b.id', 'LEFT');
        $this->db->where('a.user_id', $user);
        $this->db->orderBy('a.id', 'desc');
        return $this->db->get('carts a', null, 'a.id, a.qty, c.name, c.image, c.price, c.description, c.id as product, b.name as category');
	}

    public function findWhere($user, $product, $array = false){
        $this->db->where('user_id', $user);
        $this->db->where('product_id', $product);

        if ($array) {
            return $this->db->get('carts');
        }

        return $this->db->getOne('carts');
	}

    public function insert($data){
        return $this->db->insert('carts', $data);
	}

    public function total(){
        $this->db->where('user_id', session('user'));
        return $this->db->getValue('carts', 'sum(qty)')??0;
	}

    public function update($id, $data){
        return $this->db->where('id', $id)->update('carts', $data);
	}
}