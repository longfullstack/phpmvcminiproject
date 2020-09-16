<?php
/**
 * Entity Administrator
 */
class AdministratorEntity
{
	public $id;
	public $username;
	public $password;
    public $created_at;
    public $updated_at;
	
	public function __construct($_id, $_username, $_password, $_created_at, $_updated_at)
	{
		$this->id = $_id;
		$this->username = $_username;
		$this->password = $_password;
		$this->created_at = $_created_at;
		$this->updated_at = $_updated_at;
	}
}
