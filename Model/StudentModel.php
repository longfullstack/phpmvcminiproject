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
		$query = "SELECT * FROM students WHERE id='" . $id . "'";
		$results = $this->connection->query($query);
		if($results)
		{
			$administrators = [];
			while ($row = mysqli_fetch_assoc($results)) {
				$students[] = new StudentEntity($row['id'], $row['name'], $row['age'], $row['university']);
			}
			// Trả về giá trị cuối cùng
			return isset($students[0]) ? $students[0] : false;
		}
		else
		{
			return false;
		}
	}

	public function save($student)
	{
		if(isset($student['id']))
		{
			$query = "UPDATE students SET `name`='" . $student['name'] . "', `age`='" . $student['age'] . "', `university`='" . $student['university'] . "' WHERE `id`=" . $student['id'];
			return $this->connection->query($query);
		}
		else
		{
			$query = "INSERT INTO students (`name`,`age`,`university`) VALUES ('" . $student['name'] . "','" . $student['age'] . "','" . $student['university'] . "')";
			return $this->connection->query($query);
		}
	}

	public function delete($id)
	{
		$query = "DELETE FROM students WHERE id=" . $id;
		return $this->connection->query($query);
	}
}