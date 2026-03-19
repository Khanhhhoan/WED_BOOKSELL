<?php
class UserModel extends Model {
    
    // T�m user theo email
    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // �ang k� t�i kho?n
    public function register($data) {
        $this->db->query("INSERT INTO users (full_name, email, password, phone, role) VALUES(:full_name, :email, :password, :phone, 'user')");
        
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']); // �� hash t? controller
        $this->db->bind(':phone', $data['phone']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // �ang nh?p
    public function login($email, $password) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($row) {
            $hashed_password = $row['password'];
            if (md5($password) === $hashed_password) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // L?y th�ng tin user b?ng ID
    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // [ADMIN] L?y danh s�ch t?t c? ngu?i d�ng
    public function getAllUsers() {
        $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    // [ADMIN] X�a ngu?i d�ng (T�y ch?n)
    public function deleteUser($id) {
        $this->db->query("DELETE FROM users WHERE id = :id AND role != 'admin'");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}

