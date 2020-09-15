<?php
include_once("Controller.php");

Class HomeController extends Controller
{
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
        include_once("../View/Home/dashboard.html");
    }

    public function login() 
    {
        include_once("../View/Home/login.html");
    }

    public function loginPost() 
    {
        if(isset($_POST['loginPost']))
        {
            die('loginPost');
        }
    }

    public function register() 
    {
        include_once("../View/Home/register.html");
    }

    public function registerPost()
    {
        if(isset($_POST['registerPost']))
        {
            die('registerPost');
        }
    }
}

$homeController = new HomeController();
$homeController->invoke();
$homeController->invokePost();