<?php
class AuthController extends Controller {
    public function __construct() {
        // Đã đăng nhập thì không vào lại trang đăng nhập/đăng ký
        if (Session::isLoggedIn() && isset($_GET['url']) && $_GET['url'] != 'auth/logout') {
            $this->redirect('home');
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = array(
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            );

            $userModel = $this->model('UserModel');

            if (empty($data['email'])) {
                $data['email_err'] = 'Vui lòng nhập email';
            } elseif (!$userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email không tồn tại';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Mật khẩu không chính xác';
                    $this->view('layouts/header', array('title' => 'Đăng nhập'));
                    $this->view('auth/login', $data);
                    $this->view('layouts/footer');
                }
            } else {
                $this->view('layouts/header', array('title' => 'Đăng nhập'));
                $this->view('auth/login', $data);
                $this->view('layouts/footer');
            }
        } else {
            $data = array(
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            );

            $this->view('layouts/header', array('title' => 'Đăng nhập - BookStore'));
            $this->view('auth/login', $data);
            $this->view('layouts/footer');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = array(
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'full_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            );

            $userModel = $this->model('UserModel');

            if (empty($data['email'])) {
                $data['email_err'] = 'Vui lòng nhập email';
            } else {
                if ($userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email đã được sử dụng';
                }
            }

            if (empty($data['full_name'])) {
                $data['full_name_err'] = 'Vui lòng nhập họ tên';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Mật khẩu phải từ 6 ký tự trở lên';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Vui lòng xác nhận mật khẩu';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Mật khẩu xác nhận không khớp';
                }
            }

            if (empty($data['email_err']) && empty($data['full_name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                $data['password'] = md5($data['password']);

                if ($userModel->register($data)) {
                    Session::flash('msg', 'Đăng ký thành công, bạn có thể đăng nhập!');
                    $this->redirect('auth/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('layouts/header', array('title' => 'Đăng ký - BookStore'));
                $this->view('auth/register', $data);
                $this->view('layouts/footer');
            }
        } else {
            $data = array(
                'full_name' => '',
                'email' => '',
                'phone' => '',
                'password' => '',
                'confirm_password' => '',
                'full_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            );

            $this->view('layouts/header', array('title' => 'Đăng ký - BookStore'));
            $this->view('auth/register', $data);
            $this->view('layouts/footer');
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        $this->redirect('home');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        $this->redirect('auth/login');
    }
}
