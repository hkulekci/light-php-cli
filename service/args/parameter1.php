<?php  
class parameter1 extends Controller{
	
	public function index($data = array()){

		print_r($data);
		echo 'parameter1 file index method is runned! Args : '.serialize($data) . PHP_EOL;

		return 1;

	}

	public function run($data = array()){

		print_r($data);
		echo 'parameter1 file run method is runned! Args : '.serialize($data) . PHP_EOL;

		return 1;

	}

}
?>