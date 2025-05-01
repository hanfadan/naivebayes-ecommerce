<?php

class WishlistModel extends Model {
    public function delete($id) {
        return $this->db->where('id', $id)->delete('wishlists');
    }

    public function findAll($user){
        $this->db->join('products c', 'a.product_id = c.id', 'LEFT');
        $this->db->join('categories b', 'c.category_id = b.id', 'LEFT');
        $this->db->where('a.user_id', $user);
        $this->db->orderBy('a.id', 'desc');
        return $this->db->get('wishlists a', null, 'a.id, c.name, c.image, c.price, c.description, b.name as category');
	}

    public function findWhere($user, $product, $array = false){
        $this->db->where('user_id', $user);
        $this->db->where('product_id', $product);

        if ($array) {
            return $this->db->get('wishlists');
        }

        return $this->db->getOne('wishlists');
	}

    public function insert($data){
        return $this->db->insert('wishlists', $data);
	}
}