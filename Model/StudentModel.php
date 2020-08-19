<?php
include_once("Connection.php");
include_once("StudentEntity.php");

class StudentModel
{
	private $connection;
	public function __construct() 
	{
		// Khởi tạo Object Connection để sử dụng
		$connection = new Connection();
		// Gán connection được khởi tạo bởi Object Connection vào property của StudentModel để sử dụng
		$this->connection = $connection->connection;
	}
	
	public function getAllStudents() 
	{
		$query = 'SELECT * FROM students';
		$results = $this->connection->query($query);
		$students = [];
		// Biến đổi dữ liệu lấy ra từ cơ sở dữ liệu thành dạng mảng dễ sử dụng
		while ($row = mysqli_fetch_assoc($results)) {
			$students[$row['id']] = new StudentEntity($row['id'], $row['name'], $row['age'], $row['university']);
		}
		// Trả về giá trị cuối cùng
		return $students;
	}
	
	public function getStudentDetail($stid) 
	{
		//Gia su rang ta load data tu CSDL
		$allStudent = $this->getAllStudents();
		return $allStudent[$stid];
	}
}