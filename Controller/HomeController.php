<?php
session_start();
include_once("Controller.php");
include_once("../Model/AdministratorModel.php");

Class HomeController extends Controller
{
    private $administratorModel;
    public function __construct()
    {        
        // Khởi tạo administrator và gán vào một thuộc tính của class
        // Làm như thế này sẽ không cần thiết phải khởi tạo nhiều lần
        $_administratorModel = new AdministratorModel();
        $this->administratorModel = $_administratorModel;
    }
    public function invoke()
    {
        if(isset($_GET['view']))
        {
            include_once("../View/Layouts/header.html");
            switch($_GET['view']) 
			{
                case 'login':
                    $this->login($_GET);
                    break;
                case 'register':
                    $this->register($_GET);
                    break; 
                case 'dashboard':
                    $this->dashboard();
                    break; 
                case 'logout':
                        $this->logout($_GET);
                        break;
                default:
                    $this->error();
                    break;  
            }
            include_once("../View/Layouts/footer.html");
        } else {
            if (empty($_POST)) 
            {
                $this->error();
            }
        }
    }

    public function invokePost()
    {
        $this->loginPost();
        $this->registerPost();
    }

    public function dashboard()
    {        
        $this->isLogin();
        include_once("../View/Home/dashboard.html");
    }

    public function login() 
    {
        if(isset($_SESSION['user']))
        {
            header('Location:/Controller/HomeController?view=dashboard');
        }
        include_once("../View/Home/login.html");
    }

    public function logout() 
    {
        session_destroy();
        header('Location:/Controller/HomeController?view=login');
    }

    public function loginPost() 
    {
        if(isset($_POST['loginPost']))
        {     
            $error = $this->loginValidation($_POST);
            if($error['code'] === 0) 
            {
                $result = $this->administratorModel->checkLogin($_POST['username'], $_POST['password']);
                if($result){
                    $_SESSION['user'] = $result;
                    header('Location:/Controller/HomeController?view=dashboard');
                }
                else
                {
                    $error['code'] = 1;
                    $error['message'] = 'Username or Password does not match';
                    $this->loginError($error);
                }
            }
            else
            {
                $this->loginError($error);
            }
        }
    }

    public function loginValidation($post)
    {
        $error['code'] = 0;
        $error['message'] = "Success";
        if(!$post['username']) {
            $error['code'] = 1;
            $error['message'] = "Username can not be blank";
            return $error;
        }
        if(!$post['password'])
        {
            $error['code'] = 1;
            $error['message'] = "Password can not be blank";
            return $error;
        }
        return $error;
    }

    public function loginError($error)
    {
        include_once("../View/Layouts/header.html");
        include_once("../View/Home/login.html");
        include_once("../View/Layouts/footer.html");
    }

    public function register() 
    {
        include_once("../View/Home/register.html");
    }

    public function registerPost()
    {
        if(isset($_POST['registerPost']))
        {
            $error = $this->registerValidation($_POST);
            if($error['code'] === 0) 
            {
                $user = [];
                $user['username'] = $_POST['username'];
                $user['password'] = $_POST['password'];
                $user['created_at'] = date('Y-m-d H:i:s');
                $user['updated_at'] = date('Y-m-d H:i:s');
                if($this->administratorModel->save($user))
                {               
                    echo "<script>confirm('Registered successfully'); window.location.href='/Controller/HomeController.php?view=login'</script>";
                }
                else
                {
                    $error['code'] = 1;
                    $error['message'] = "System error, please contact admin";
                    $this->registerError($error);
                }
            }
            else
            {                
                $this->registerError($error);
            }
        }
    }

    public function registerValidation($post)
    {        
        $error['code'] = 0;
        $error['message'] = "Success";
        if(!$post['username']) {
            $error['code'] = 1;
            $error['message'] = "Username can not be blank";
            return $error;
        }
        if(!$post['password'])
        {
            $error['code'] = 1;
            $error['message'] = "Password can not be blank";
            return $error;
        }
        if($post['password'] != $post['rePassword'])
        {
            $error['code'] = 1;
            $error['message'] = "Password does not match";
            return $error;
        }
        return $error;
    }

    public function registerError($error)
    {
        include_once("../View/Layouts/header.html");
        include_once("../View/Home/register.html");
        include_once("../View/Layouts/footer.html");
    }
}

$homeController = new HomeController();
$homeController->invoke();
$homeController->invokePost();