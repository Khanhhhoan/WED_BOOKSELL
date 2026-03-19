<?php
// Bắt đầu session
if (session_id() == '') {
    session_start();
}

class Session {
    // Set biến session
    public static function set($key, $val) {
        $_SESSION[$key] = $val;
    }

    // Lấy biến session
    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    // Kiểm tra session tồn tại
    public static function exists($name) {
        return isset($_SESSION[$name]) ? true : false;
    }

    // Xóa session
    public static function delete($name) {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    // Hủy bỏ toàn bộ session (Đăng xuất)
    public static function destroy() {
        session_destroy();
    }

    // Flash message helper
    // VÍ DỤ: Session::flash('register_success', 'Đăng ký thành công');
    // Hiển thị: echo Session::flash('register_success');
    public static function flash($name = '', $message = '', $class = 'alert alert-success') {
        if (!empty($name)) {
            if (!empty($message) && empty($_SESSION[$name])) {
                if (!empty($_SESSION[$name])) {
                    unset($_SESSION[$name]);
                }

                if (!empty($_SESSION[$name . '_class'])) {
                    unset($_SESSION[$name . '_class']);
                }

                $_SESSION[$name] = $message;
                $_SESSION[$name . '_class'] = $class;
            } elseif (empty($message) && !empty($_SESSION[$name])) {
                $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
                echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name . '_class']);
            }
        }
    }

    // Check login state helper
    public static function isLoggedIn() {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    // Lấy thông tin user đăng nhập
    public static function authUser() {
        if (self::isLoggedIn()) {
            return array(
                'id' => $_SESSION['user_id'],
                'full_name' => $_SESSION['user_name'],
                'role' => $_SESSION['user_role']
            );
        }
        return false;
    }
}

