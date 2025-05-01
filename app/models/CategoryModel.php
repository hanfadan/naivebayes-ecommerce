<?php

class CategoryModel extends Model {
    public function delete($id) {
        return $this->db->where('id', $id)->delete('categories');
    }

    public function dropdownMenu(){
        $html = '<ul class="dropdown">';
        $categories = $this->findWhere('parent_id', 0);

        foreach ($categories as $value) {
            $html .= '<li><a href="'.url('product?category='.$value['slug']).'">'.$value['name'].'</a>';

            $parents = $this->findWhere('parent_id', $value['id']);

            if (!empty($parents))
            {
                $html .= '<ul>';
            }

            foreach ($parents as $value) {
                $html .= '<li><a href="'.url('product?category='.$value['slug']).'">'.$value['name'].'</a></li>';
            }

            if (!empty($parents))
            {
                $html .= '</ul>';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';

        return $html;
    }

    public function findAll(){
        return $this->db->get('categories');
	}

    public function findOne($id){
        return $this->db->where('id', $id)->getOne('categories');
	}

    public function findWhere($key, $val){
        return $this->db->where($key, $val)->get('categories');
	}

    public function insert($data){
        return $this->db->insert('categories', $data);
	}

    public function selectTree(){
        $html = '';
        $categories = $this->findWhere('parent_id', 0);

        foreach ($categories as $value) {
            $html .= '<option value="'.$value['slug'].'">'.$value['name'].'</option>';

            $parents = $this->findWhere('parent_id', $value['id']);

            foreach ($parents as $value) {
                $html .= '<option value="'.$value['slug'].'">&#160;&#160;'.$value['name'].'</option>';
            }
        }

        return $html;
    }

    public function sidebars(){
        $html = '<ul class="categor-list">';
        $categories = $this->findWhere('parent_id', 0);

        foreach ($categories as $value) {
            $html .= '<li><a href="'.url('product?category='.$value['slug']).'">'.$value['name'].'</a>';

            $parents = $this->findWhere('parent_id', $value['id']);

            if (!empty($parents))
            {
                $html .= '<ul class="categor-list">';
            }

            foreach ($parents as $value) {
                $html .= '<li><a href="'.url('product?category='.$value['slug']).'">'.$value['name'].'</a></li>';
            }

            if (!empty($parents))
            {
                $html .= '</ul>';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';

        return $html;
    }

    public function update($id, $data){
        return $this->db->where('id', $id)->update('categories', $data);
	}
}