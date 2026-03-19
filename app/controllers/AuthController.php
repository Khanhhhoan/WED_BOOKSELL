<?php
class AuthController extends Controller {
    public function __construct() {
        // N?u dï¿½ dang nh?p thï¿½ khï¿½ng cho vï¿½o trang auth n?a
        if (Session::isLoggedIn() && isset($_GET['url']) && $_GET['url'] != 'auth/logout') {
            $this->redirect('home');
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate & Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = array(
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            );

            $userModel = $this->model('UserModel');

            if (empty($data['email'])) {
                $data['email_err'] = 'Vui lï¿½ng nh?p email';
            } elseif (!$userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email khï¿½ng t?n t?i';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lï¿½ng nh?p m?t kh?u';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'M?t kh?u khï¿½ng chï¿½nh xï¿½c';
                    $this->view('layouts/header', array('title' => 'ï¿½ang Nh?p'));
                    $this->view('auth/login', $data);
                    $this->view('layouts/footer');
                }
            } else {
                $this->view('layouts/header', array('title' => 'ï¿½ang Nh?p'));
                $this->view('auth/login', $data);
                $this->view('layouts/footer');
            }
        } else {
            // Init data
            $data = array(
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            );

            $this->view('layouts/header', array('title' => 'ï¿½ang Nh?p - BookStore'));
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
                $data['email_err'] = 'Vui lï¿½ng nh?p email';
            } else {
                if ($userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email dï¿½ du?c s? d?ng';
                }
            }

            if (empty($data['full_name'])) {
                $data['full_name_err'] = 'Vui lï¿½ng nh?p h? tï¿½n';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lï¿½ng nh?p m?t kh?u';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'M?t kh?u ph?i t? 6 kï¿½ t? tr? lï¿½n';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Vui lï¿½ng xï¿½c nh?n m?t kh?u';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'M?t kh?u xï¿½c nh?n khï¿½ng kh?p';
                }
            }

            if (empty($data['email_err']) && empty($data['full_name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                $data['password'] = md5($data['password']);

                if ($userModel->register($data)) {
                    Session::flash('msg', 'ï¿½ang kï¿½ thï¿½nh cï¿½ng, b?n cï¿½ th? dang nh?p!');
                    $this->redirect('auth/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('layouts/header', array('title' => 'ï¿½ang Kï¿½ - BookStore'));
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

            $this->view('layouts/header', array('title' => 'ï¿½ang Kï¿½ - BookStore'));
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

