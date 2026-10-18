<?php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {
        // Cấu hình DSN (Data Source Name)
        $portPart = (defined('DB_PORT') && DB_PORT !== '' && DB_PORT !== '3306') ? ';port=' . DB_PORT : '';
        $dsn = 'mysql:host=' . $this->host . $portPart . ';dbname=' . $this->dbname . ';charset=utf8';
        
        // Opts cho PDO
        $options = array(
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        // Hỗ trợ kết nối SSL cho Cloud MySQL (Aiven, PlanetScale, Railway)
        if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
            $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }

        // Tạo đối tượng PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            $this->dbh->exec("SET NAMES 'utf8'");
            $this->dbh->exec("SET time_zone = '+07:00'");
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            die("Lỗi kết nối CSDL: " . $this->error);
        }
    }

    // Chuẩn bị câu lệnh SQL
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Gán tham số vào câu SQL
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Thực thi câu lệnh
    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            // Tự động mở rộng cột image nếu gặp lỗi Data too long cho cột 'image' (SQLSTATE 22001, error 1406)
            $msg = $e->getMessage();
            if (($e->getCode() == '22001' || strpos($msg, '1406') !== false) && stripos($msg, "'image'") !== false) {
                try {
                    $this->dbh->exec("ALTER TABLE books MODIFY COLUMN image MEDIUMTEXT");
                    $this->dbh->exec("ALTER TABLE posts MODIFY COLUMN image MEDIUMTEXT");
                    return $this->stmt->execute();
                } catch (Exception $ex) {
                    // Tiếp tục ném exception gốc bên dưới
                }
            }
            throw $e;
        }
    }

    // Lấy nhiều bản ghi (dạng mảng các object hoặc mảng kết hợp)
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // Lấy một bản ghi
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    // Đếm số dòng thay đổi/ảnh hưởng
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    // Lấy ID vừa insert
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
}

