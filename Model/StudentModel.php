<?php
include_once("Model.php");
include_once("StudentEntity.php");

class StudentModel extends Model
{
	public function __construct() 
	{
		return parent::__construct();
	}
	
	public function list() 
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
	
	public function detail($id) 
	{
		//Gia su rang ta load data tu CSDL
		$allStudent = $this->list();
		return $allStudent[$id];
	}

	public function save($student)
	{
		
	}
}