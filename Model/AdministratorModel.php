<?php
include_once("Model.php");
include_once("AdministratorEntity.php");

class AdministratorModel extends Model
{
	public function __construct() 
	{
		return parent::__construct();
	}
	
	public function list() 
	{
		$query = 'SELECT * FROM administrators';
		$results = $this->connection->query($query);
		$administrators = [];
		// Biến đổi dữ liệu lấy ra từ cơ sở dữ liệu thành dạng mảng dễ sử dụng
		while ($row = mysqli_fetch_assoc($results)) {
			$administrators[$row['id']] = new AdministratorEntity($row['id'], $row['username'], $row['password'], $row['created_at'], $row['updated_at']);
		}
		// Trả về giá trị cuối cùng
		return $administrators;
	}
	
	public function detail($id) 
	{
		//Ta load data tu CSDL
		$query = "SELECT * FROM administrators WHERE id='" . $id . "'";
		$results = $this->connection->query($query);
		if($results)
		{
			$administrators = [];
			while ($row = mysqli_fetch_assoc($results)) {
				$administrators[] = new AdministratorEntity($row['id'], $row['username'], $row['password'], $row['created_at'], $row['updated_at']);
			}
			// Trả về giá trị cuối cùng
			return isset($administrators[0]) ? $administrators[0] : false;
		}
		else
		{
			return false;
		}
	}

	public function save($data)
	{
		$query = "INSERT INTO administrators (`username`, `password`, `created_at`, `updated_at`) VALUES ('" . $data['username'] . "','" . md5($data['password']) . "','" . $data['created_at'] . "', '" . $data['updated_at'] . "')";
		
		$results = $this->connection->query($query);
		if($results)
		{
			return $this->connection->insert_id;
		}
		else 
		{
			return 0;
		}
	}

	public function checkLogin($username, $password)
	{
		// Câu lệnh query để lấy ra người dùng có username, password tương ứng
		$query = "SELECT * FROM administrators WHERE `username`='" . $username . "' AND `password`='" . md5($password) . "' ORDER BY `created_at` LIMIT 1";
		$results = $this->connection->query($query);
		if($results)
		{
			$administrators = [];
			while ($row = mysqli_fetch_assoc($results)) {
				$administrators[] = new AdministratorEntity($row['id'], $row['username'], $row['password'], $row['created_at'], $row['updated_at']);
			}
			// Trả về giá trị cuối cùng
			return isset($administrators[0]) ? $administrators[0] : false;
		}
		else
		{
			return false;
		}
	}
}