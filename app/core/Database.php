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
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8';
        
        // Opts cho PDO
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        // Tạo đối tượng PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
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
        return $this->stmt->execute();
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

