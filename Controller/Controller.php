<?php
class Controller 
{
    public function error() 
	{
		include_once("../View/Layouts/header.html");
		include_once("../View/Errors/404.html");
		include_once("../View/Layouts/footer.html");
	}
}