<?php
class OrderController extends Controller {
    
    public function __construct() {
        // Ch? cho ph�p user dang nh?p v�o Order
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'B?n c?n dang nh?p d? th?c hi?n ch?c nang n�y.');
            $this->redirect('auth/login');
        }
    }

    public function checkout() {
        if (empty($_SESSION['cart'])) {
            $this->redirect('cart');
        }

        // N?u submit form thanh to�n
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $cart = $_SESSION['cart'];
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $data = array(
                'user_id' => $_SESSION['user_id'],
                'cart' => $cart,
                'total_amount' => $total,
                'shipping_name' => trim($_POST['shipping_name']),
                'shipping_phone' => trim($_POST['shipping_phone']),
                'shipping_address' => trim($_POST['shipping_address']),
                'payment_method' => $_POST['payment_method'], // cod or online
            );

            // Validate don gi?n
            if (empty($data['shipping_name']) || empty($data['shipping_phone']) || empty($data['shipping_address'])) {
                Session::flash('error', 'Vui l�ng di?n d?y d? th�ng tin giao h�ng.');
                $this->redirect('order/checkout');
            }

            $orderModel = $this->model('OrderModel');
            $orderId = $orderModel->createOrder($data);

            if ($orderId) {
                // X�a gi? h�ng
                unset($_SESSION['cart']);
                
                // Chuy?n t?i trang th�nh c�ng
                Session::flash('msg', '�?t h�ng th�nh c�ng! M� don h�ng c?a b?n l� <strong>#ORD' . $orderId . '</strong>');
                $this->redirect('order/success/' . $orderId);
            } else {
                Session::flash('error', '�� x?y ra l?i h? th?ng, vui l�ng th? l?i.');
                $this->redirect('order/checkout');
            }
        } 
        // Hi?n th? form checkout
        else {
            $cart = $_SESSION['cart'];
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $userModel = $this->model('UserModel');
            $userInfo = $userModel->getUserById($_SESSION['user_id']);

            $data = array(
                'title' => 'Thanh To�n �on H�ng - BookStore',
                'cart' => $cart,
                'total' => $total,
                'user' => $userInfo
            );

            $this->view('layouts/header', $data);
            $this->view('order/checkout', $data);
            $this->view('layouts/footer');
        }
    }

    public function success($orderId = '') {
        $data = array(
            'title' => '�?t H�ng Th�nh C�ng',
            'orderId' => $orderId
        );
        
        $this->view('layouts/header', $data);
        $this->view('order/success', $data);
        $this->view('layouts/footer');
    }

    public function history() {
        $orderModel = $this->model('OrderModel');
        $orders = $orderModel->getOrdersByUser($_SESSION['user_id']);

        $data = array(
            'title' => 'L?ch S? �on H�ng - BookStore',
            'orders' => $orders
        );

        $this->view('layouts/header', $data);
        $this->view('order/history', $data);
        $this->view('layouts/footer');
    }
}

