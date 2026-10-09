<?php
class OrderController extends Controller {
    
    public function __construct() {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Bạn cần đăng nhập để thực hiện chức năng này.');
            $this->redirect('auth/login');
        }
    }

    public function checkout() {
        if (empty($_SESSION['cart'])) {
            $this->redirect('cart');
        }

        // Gửi form thanh toán
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cart = $_SESSION['cart'];
            $bookModel = $this->model('BookModel');
            foreach ($cart as $bookId => $item) {
                $b = $bookModel->getBookById($bookId, true);
                if (!$b || (int) $b['stock'] < (int) $item['quantity']) {
                    Session::flash('error', 'Giỏ hàng có sách không còn bán hoặc không đủ tồn kho. Vui lòng cập nhật giỏ hàng.');
                    $this->redirect('cart');
                }
            }

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

            if (empty($data['shipping_name']) || empty($data['shipping_phone']) || empty($data['shipping_address'])) {
                Session::flash('error', 'Vui lòng điền đầy đủ thông tin giao hàng.');
                $this->redirect('order/checkout');
            }

            $orderModel = $this->model('OrderModel');
            $orderId = $orderModel->createOrder($data);

            if ($orderId) {
                unset($_SESSION['cart']);

                if ($data['payment_method'] === 'sepay' || $data['payment_method'] === 'online') {
                    Session::flash('msg', 'Đơn hàng <strong>#ORD' . $orderId . '</strong> đã khởi tạo! Vui lòng quét mã QR để chuyển khoản thanh toán.');
                    $this->redirect('sepay/pay/' . $orderId);
                } else {
                    Session::flash('msg', 'Đặt hàng thành công! Mã đơn hàng của bạn là <strong>#ORD' . $orderId . '</strong>');
                    $this->redirect('order/success/' . $orderId);
                }
            } else {
                Session::flash('error', 'Đã xảy ra lỗi hệ thống, vui lòng thử lại.');
                $this->redirect('order/checkout');
            }
        } 
        // Form checkout
        else {
            $cart = $_SESSION['cart'];
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $userModel = $this->model('UserModel');
            $userInfo = $userModel->getUserById($_SESSION['user_id']);

            $data = array(
                'title' => 'Thanh toán đơn hàng - BookStore',
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
        $orderModel = $this->model('OrderModel');
        $payment = $orderModel->getPaymentByOrderId($orderId);
        $order = null;
        if (!empty($orderId)) {
            $order = $orderModel->getOrderByIdAdmin($orderId);
        }

        $data = array(
            'title' => 'Đặt hàng thành công',
            'orderId' => $orderId,
            'payment' => $payment,
            'order' => $order
        );
        
        $this->view('layouts/header', $data);
        $this->view('order/success', $data);
        $this->view('layouts/footer');
    }

    public function history() {
        $orderModel = $this->model('OrderModel');
        $orders = $orderModel->getOrdersByUser($_SESSION['user_id']);

        $data = array(
            'title' => 'Lịch sử đơn hàng - BookStore',
            'orders' => $orders
        );

        $this->view('layouts/header', $data);
        $this->view('order/history', $data);
        $this->view('layouts/footer');
    }
}

