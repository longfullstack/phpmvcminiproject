<?php
include_once("Connection.php");
abstract Class Model {
    protected $connection;

    protected function __construct() {
		// Khởi tạo Object Connection để sử dụng
		$connection = new Connection();
		// Gán connection được khởi tạo bởi Object Connection vào property của StudentModel để sử dụng
		$this->connection = $connection->connection;
    }

    abstract public function list();
    abstract public function detail($id);
}