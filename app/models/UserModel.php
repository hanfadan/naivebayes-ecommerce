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

    /**
     * Login dengan email atau telepon.
     *
     * @param  string $identity  Email atau nomor telepon
     * @param  string $password  (Sudah di-hash sesuai controller)
     * @return string|false      'admin' atau 'user' kalau sukses, false kalau gagal
     */
    public function login(string $identity, string $password)
    {
        // Cari user di kolom phone ATAU email
    $this->db->where('phone', $identity);
    $this->db->orWhere('email', $identity);
    $user = $this->db->getOne('users');

    if (empty($user)) {
        die("User tidak ditemukan");
    }

    if ($user['password'] !== $password) {
        die("Password tidak cocok. Input: $password | Di DB: " . $user['password']);
    }

        // Cocokkan password
        if ($user['password'] === $password) {
            // Simpan session
            sessave('user',  $user['id']);
            sessave('name',  $user['name']);
            sessave('phone', $user['phone']);

            if ($user['role'] === 'admin') {
                sessave('isAdmin', true);
                return 'admin';
            } else {
                sessave('isUser', true);
                return 'user';
            }
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