<?php
class CartController extends Controller {

    public function __construct() {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Vui lòng đăng nhập để sử dụng giỏ hàng và đặt hàng.');
            $this->redirect('auth/login');
        }
    }

    public function index() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $data = array(
            'title' => 'Giỏ hàng của bạn - BookStore',
            'cart' => $cart,
            'total' => $total
        );

        $this->view('layouts/header', $data);
        $this->view('cart/index', $data);
        $this->view('layouts/footer');
    }

    public function add($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
            $bookModel = $this->model('BookModel');
            $book = $bookModel->getBookById($id, true);

            if ($book) {
                // Khởi tạo giỏ hàng nếu chưa có
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }

                $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

                // Kiểm tra sản phẩm đã có trong giỏ chưa
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] += $qty;
                } else {
                    $_SESSION['cart'][$id] = array(
                        'id' => $book['id'],
                        'title' => $book['title'],
                        'price' => $book['price'],
                        'image' => $book['image'],
                        'quantity' => $qty
                    );
                }

                Session::flash('msg', 'Đã thêm <strong>' . htmlspecialchars($book['title']) . '</strong> vào giỏ hàng!');
                
                // POST → về giỏ; GET → quay lại trang trước
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $this->redirect('cart');
                } else {
                    // Redirect back to previous page
                    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL . 'book';
                    header("Location: $referer");
                    exit;
                }
            } else {
                Session::flash('error', 'Sản phẩm không tồn tại hoặc đã ngừng bán.');
                $this->redirect('book');
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quantities = $_POST['quantity']; // mảng id => số lượng
            
            if (isset($_SESSION['cart']) && !empty($quantities)) {
                foreach ($quantities as $id => $qty) {
                    if ($qty > 0 && isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id]['quantity'] = $qty;
                    } elseif ($qty <= 0) {
                        unset($_SESSION['cart'][$id]);
                    }
                }
                Session::flash('msg', 'Giỏ hàng đã được cập nhật.');
            }
        }
        $this->redirect('cart');
    }

    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            Session::flash('msg', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        }
        $this->redirect('cart');
    }

    public function clear() {
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            Session::flash('msg', 'Đã xóa toàn bộ giỏ hàng.');
        }
        $this->redirect('cart');
    }
}

