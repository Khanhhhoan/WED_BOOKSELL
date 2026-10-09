<?php
/**
 * Controller xử lý Thanh Toán SePay (Cổng chuyển khoản ngân hàng tự động VietQR)
 * Tương thích PHP 5.2
 */
class SepayController extends Controller {

    /**
     * Trang hiển thị mã VietQR SePay và thông tin chuyển khoản cho khách hàng
     */
    public function pay($orderId = '') {
        $orderId = (int)$orderId;
        if ($orderId <= 0) {
            $this->redirect('order/history');
        }

        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Vui lòng đăng nhập để xem thông tin đơn hàng.');
            $this->redirect('auth/login');
        }

        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderByIdAdmin($orderId);

        if (!$order) {
            Session::flash('error', 'Đơn hàng không tồn tại.');
            $this->redirect('order/history');
        }

        // Kiểm tra quyền sở hữu đơn hàng (chỉ chủ đơn hoặc admin được xem)
        if ($order['user_id'] != $_SESSION['user_id'] && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')) {
            Session::flash('error', 'Bạn không có quyền truy cập đơn hàng này.');
            $this->redirect('home');
        }

        $payment = $orderModel->getPaymentByOrderId($orderId);

        // Nếu đơn hàng đã được thanh toán thành công
        if ($payment && $payment['status'] === 'success') {
            Session::flash('msg', 'Đơn hàng <strong>#ORD' . $orderId . '</strong> đã được thanh toán thành công!');
            $this->redirect('order/success/' . $orderId);
        }

        // Lấy cấu hình SePay
        $bank = get_sepay_config('sepay_bank');
        $accNo = get_sepay_config('sepay_account_no');
        $accName = get_sepay_config('sepay_account_name');
        $prefix = get_sepay_config('sepay_prefix');
        if (empty($prefix)) {
            $prefix = 'DH';
        }
        $template = get_sepay_config('sepay_qr_template');
        if (empty($template)) {
            $template = 'compact';
        }

        $amount = (int)$order['total_amount'];
        $transferContent = $prefix . $orderId;
        $qrUrl = generate_sepay_qr_url($bank, $accNo, $amount, $transferContent, $template);
        $items = $orderModel->getOrderDetailsAdmin($orderId);

        $data = array(
            'title' => 'Thanh Toán Đơn Hàng #ORD' . $orderId . ' - SePay QR',
            'order' => $order,
            'payment' => $payment,
            'items' => $items,
            'orderId' => $orderId,
            'bank' => $bank,
            'accNo' => $accNo,
            'accName' => $accName,
            'amount' => $amount,
            'transferContent' => $transferContent,
            'qrUrl' => $qrUrl
        );

        $this->view('layouts/header', $data);
        $this->view('order/sepay_pay', $data);
        $this->view('layouts/footer');
    }

    /**
     * API kiểm tra trạng thái thanh toán theo mã đơn hàng (Client Polling mỗi 3s)
     */
    public function check_status($orderId = '') {
        header('Content-Type: application/json; charset=UTF-8');
        $orderId = (int)$orderId;

        if ($orderId <= 0) {
            echo json_encode(array(
                'success' => false,
                'paid' => false,
                'message' => 'Mã đơn hàng không hợp lệ'
            ));
            exit;
        }

        $orderModel = $this->model('OrderModel');
        $payment = $orderModel->getPaymentByOrderId($orderId);

        if ($payment && $payment['status'] === 'success') {
            echo json_encode(array(
                'success' => true,
                'paid' => true,
                'status' => 'success',
                'transaction_id' => $payment['transaction_id'],
                'message' => 'Đã nhận được thanh toán thành công!'
            ));
            exit;
        }

        echo json_encode(array(
            'success' => true,
            'paid' => false,
            'status' => 'pending',
            'message' => 'Đang chờ khách hàng chuyển khoản...'
        ));
        exit;
    }

    /**
     * Webhook nhận dữ liệu thanh toán từ SePay Server (HTTP POST JSON)
     */
    public function webhook() {
        header('Content-Type: application/json; charset=UTF-8');

        // Chỉ chấp nhận HTTP POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(array('success' => false, 'message' => 'Phương thức không được hỗ trợ (Chỉ nhận POST)'));
            exit;
        }

        // Đọc raw JSON body
        $rawInput = file_get_contents('php://input');
        if (empty($rawInput)) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(array('success' => false, 'message' => 'Dữ liệu đầu vào trống'));
            exit;
        }

        $payload = json_decode($rawInput, true);
        if (!$payload || !is_array($payload)) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(array('success' => false, 'message' => 'Dữ liệu JSON không hợp lệ'));
            exit;
        }

        // Xác thực API Key nếu đã được cấu hình trong hệ thống
        $configuredKey = get_sepay_config('sepay_api_key');
        if (!empty($configuredKey)) {
            $authHeader = '';
            if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
                $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            } elseif (isset($_GET['api_key'])) {
                $authHeader = $_GET['api_key'];
            }

            // Xử lý tiền tố 'Apikey ' hoặc 'Bearer ' từ SePay
            $token = trim(str_ireplace(array('Apikey', 'Bearer'), '', $authHeader));
            if ($token !== $configuredKey && $authHeader !== $configuredKey && (!isset($_GET['api_key']) || $_GET['api_key'] !== $configuredKey)) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(array('success' => false, 'message' => 'Xác thực thất bại: API Key không chính xác'));
                exit;
            }
        }

        // Trích xuất các trường dữ liệu từ Webhook SePay
        $gateway = isset($payload['gateway']) ? $payload['gateway'] : 'SePay';
        $transactionDate = isset($payload['transactionDate']) ? $payload['transactionDate'] : date('Y-m-d H:i:s');
        $accountNumber = isset($payload['accountNumber']) ? $payload['accountNumber'] : '';
        $subAccount = isset($payload['subAccount']) ? $payload['subAccount'] : '';
        $transferType = isset($payload['transferType']) ? $payload['transferType'] : 'in';
        $transferAmount = isset($payload['transferAmount']) ? floatval($payload['transferAmount']) : 0;
        $accumulated = isset($payload['accumulated']) ? floatval($payload['accumulated']) : 0;
        $code = isset($payload['code']) ? $payload['code'] : '';
        $content = isset($payload['content']) ? $payload['content'] : '';
        $referenceCode = isset($payload['referenceCode']) ? $payload['referenceCode'] : '';
        $description = isset($payload['description']) ? $payload['description'] : '';

        $logModel = $this->model('PaymentLogModel');
        $orderModel = $this->model('OrderModel');

        // Bỏ qua nếu là biến động tiền ra (out)
        if ($transferType !== 'in') {
            $logData = array(
                'order_id' => null,
                'gateway' => $gateway,
                'transaction_date' => $transactionDate,
                'account_number' => $accountNumber,
                'sub_account' => $subAccount,
                'transfer_type' => $transferType,
                'transfer_amount' => $transferAmount,
                'accumulated' => $accumulated,
                'code' => $code,
                'content' => $content,
                'reference_code' => $referenceCode,
                'description' => 'Biến động tiền ra (Bỏ qua)',
                'status' => 'ignored',
                'raw_data' => $rawInput
            );
            $logModel->logTransaction($logData);
            echo json_encode(array('success' => true, 'message' => 'Bỏ qua biến động tiền ra'));
            exit;
        }

        // Chống lặp giao dịch (Deduplication)
        if (!empty($referenceCode) && $logModel->isTransactionProcessed($referenceCode)) {
            $logData = array(
                'order_id' => null,
                'gateway' => $gateway,
                'transaction_date' => $transactionDate,
                'account_number' => $accountNumber,
                'sub_account' => $subAccount,
                'transfer_type' => $transferType,
                'transfer_amount' => $transferAmount,
                'accumulated' => $accumulated,
                'code' => $code,
                'content' => $content,
                'reference_code' => $referenceCode,
                'description' => 'Giao dịch trùng lặp (Đã được xác nhận trước đó)',
                'status' => 'duplicate',
                'raw_data' => $rawInput
            );
            $logModel->logTransaction($logData);
            echo json_encode(array('success' => true, 'message' => 'Giao dịch đã được ghi nhận trước đó'));
            exit;
        }

        // Nhận diện mã đơn hàng từ nội dung chuyển khoản
        $prefix = get_sepay_config('sepay_prefix');
        if (empty($prefix)) {
            $prefix = 'DH';
        }
        $orderId = null;

        // 1. Khớp tiền tố cấu hình (ví dụ DH15)
        if (preg_match('/' . preg_quote($prefix, '/') . '\s*([0-9]+)/i', $content, $matches)) {
            $orderId = (int)$matches[1];
        }
        // 2. Khớp các tiền tố thông dụng khác (ORD15, BK15, SEPAY15)
        elseif (preg_match('/(?:ORD|BK|BOOKSTORE|SEPAY)\s*([0-9]+)/i', $content, $matches)) {
            $orderId = (int)$matches[1];
        }
        // 3. Khớp chuỗi số độc lập
        elseif (preg_match('/([0-9]{1,8})/', $content, $matches)) {
            $candidateId = (int)$matches[1];
            $testOrder = $orderModel->getOrderByIdAdmin($candidateId);
            if ($testOrder) {
                $orderId = $candidateId;
            }
        }

        // Xử lý khi tìm thấy đơn hàng
        if ($orderId) {
            $order = $orderModel->getOrderByIdAdmin($orderId);
            if ($order) {
                $orderTotal = floatval($order['total_amount']);

                // Kiểm tra số tiền chuyển có đủ không
                if ($transferAmount >= $orderTotal) {
                    $ref = !empty($referenceCode) ? $referenceCode : (!empty($code) ? $code : 'SP_' . time());
                    $orderModel->confirmOrderPayment($orderId, $ref);

                    $logData = array(
                        'order_id' => $orderId,
                        'gateway' => $gateway,
                        'transaction_date' => $transactionDate,
                        'account_number' => $accountNumber,
                        'sub_account' => $subAccount,
                        'transfer_type' => $transferType,
                        'transfer_amount' => $transferAmount,
                        'accumulated' => $accumulated,
                        'code' => $code,
                        'content' => $content,
                        'reference_code' => $ref,
                        'description' => 'Thanh toán thành công đơn hàng #ORD' . $orderId . ' qua ' . $gateway,
                        'status' => 'success',
                        'raw_data' => $rawInput
                    );
                    $logModel->logTransaction($logData);

                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thanh toán đơn hàng #ORD' . $orderId . ' thành công',
                        'order_id' => $orderId
                    ));
                    exit;
                } else {
                    // Chuyển thiếu tiền
                    $ref = !empty($referenceCode) ? $referenceCode : (!empty($code) ? $code : 'SP_' . time());
                    $logData = array(
                        'order_id' => $orderId,
                        'gateway' => $gateway,
                        'transaction_date' => $transactionDate,
                        'account_number' => $accountNumber,
                        'sub_account' => $subAccount,
                        'transfer_type' => $transferType,
                        'transfer_amount' => $transferAmount,
                        'accumulated' => $accumulated,
                        'code' => $code,
                        'content' => $content,
                        'reference_code' => $ref,
                        'description' => 'Số tiền chuyển không đủ: nhận ' . number_format($transferAmount) . ' đ, cần ' . number_format($orderTotal) . ' đ',
                        'status' => 'amount_mismatch',
                        'raw_data' => $rawInput
                    );
                    $logModel->logTransaction($logData);

                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Số tiền chuyển nhỏ hơn tổng tiền đơn hàng',
                        'order_id' => $orderId,
                        'received' => $transferAmount,
                        'required' => $orderTotal
                    ));
                    exit;
                }
            }
        }

        // Không tìm thấy đơn hàng tương ứng
        $ref = !empty($referenceCode) ? $referenceCode : (!empty($code) ? $code : 'SP_' . time());
        $logData = array(
            'order_id' => null,
            'gateway' => $gateway,
            'transaction_date' => $transactionDate,
            'account_number' => $accountNumber,
            'sub_account' => $subAccount,
            'transfer_type' => $transferType,
            'transfer_amount' => $transferAmount,
            'accumulated' => $accumulated,
            'code' => $code,
            'content' => $content,
            'reference_code' => $ref,
            'description' => 'Không tìm thấy đơn hàng khớp với nội dung: ' . $content,
            'status' => 'unmatched',
            'raw_data' => $rawInput
        );
        $logModel->logTransaction($logData);

        echo json_encode(array(
            'success' => true,
            'message' => 'Đã lưu log giao dịch (Không tìm thấy mã đơn hàng phù hợp)',
            'status' => 'unmatched'
        ));
        exit;
    }
}
