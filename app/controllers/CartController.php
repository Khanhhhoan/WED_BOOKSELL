<?php
class CartController extends Controller {
    public function index() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $data = array(
            'title' => 'Gi? H�ng C?a B?n - BookStore',
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
            $book = $bookModel->getBookById($id);

            if ($book) {
                // Kh?i t?o gi? h�ng n?u chua c�
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }

                $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

                // Ki?m tra xem s?n ph?m d� c� trong gi? h�ng chua
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

                Session::flash('msg', '�� th�m <strong>' . htmlspecialchars($book['title']) . '</strong> v�o gi? h�ng!');
                
                // N?u l� t? form (post) th� v? gi? h�ng, n?u get th� tu?
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $this->redirect('cart');
                } else {
                    // Redirect back to previous page
                    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL . 'book';
                    header("Location: $referer");
                    exit;
                }
            } else {
                Session::flash('error', 'S?n ph?m kh�ng t?n t?i!');
                $this->redirect('book');
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quantities = $_POST['quantity']; // M?ng ch?a ID v� quantity m?i
            
            if (isset($_SESSION['cart']) && !empty($quantities)) {
                foreach ($quantities as $id => $qty) {
                    if ($qty > 0 && isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id]['quantity'] = $qty;
                    } elseif ($qty <= 0) {
                        unset($_SESSION['cart'][$id]);
                    }
                }
                Session::flash('msg', 'Gi? h�ng d� du?c c?p nh?t.');
            }
        }
        $this->redirect('cart');
    }

    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            Session::flash('msg', '�� x�a s?n ph?m kh?i gi? h�ng.');
        }
        $this->redirect('cart');
    }

    public function clear() {
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            Session::flash('msg', '�� x�a to�n b? gi? h�ng.');
        }
        $this->redirect('cart');
    }
}

