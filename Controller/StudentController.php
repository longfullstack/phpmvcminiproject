<?php

include_once("../Model/StudentModel.php");

//1. Declaration
/**
 * Định nghĩa Class StudentController
 */
class  StudentController
{
	/**
	 * Định nghĩa hàm 
	 */
	public function invoke(){
				if(isset($_GET['stid'])) { // Check nếu có student id thì load view xem detail
			$modelStudent =  new StudentModel();
			$student = $modelStudent->detail($_GET['stid']);
			
			include_once("../View/StudentDetail.html");
		} else { // Check nếu không có studen id thì load view xem danh sách

			$modelStudent =  new StudentModel();
			$studentList = $modelStudent->list();
			
			include_once("../View/StudentList.html");
		}
	}
};


//////////////////////////////////////
//2. Process
// Khởi tạo StudenController và chạy 
$studentController = new StudentController();
$studentController->invoke();