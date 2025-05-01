<?php

class UserModel extends Model {
    public function delete($id) {
        return $this->db->where('id', $id)->delete('users');
    }

    public function findAll($key = '', $value = ''){
        if (!empty($key)) {
            $this->db->where($key, $value);
        }

        return $this->db->get('users');
	}

    public function findWhere($key, $val){
        return $this->db->where($key, $val)->getOne('users');
	}

    public function login($phone, $password){
        $this->db->where('phone', $phone);
        $user = $this->db->getOne('users');

        if (empty($user)) {
            return false;
        }

        if ($user['password'] === $password) {
            sessave('user', $user['id']);
            sessave('name', $user['name']);
            sessave('phone', $phone);
            if ($user['role'] === 'admin') {
                sessave('isAdmin', true);
            } else {
                sessave('isUser', true);
            }
            return $user['role'];
        }
        
		return false;
	}

    public function store($data){
        if ($this->db->insert('users', $data)) {
            return true;
        }
        
		return false;
	}

    public function update($id, $data){
        return $this->db->where('id', $id)->update('users', $data);
	}
}