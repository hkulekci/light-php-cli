<?php  
class parameter2 extends Controller{
	
	public function index($data = array()){

		echo 'parameter2 file index method is runned! Args : '.serialize($data).PHP_EOL;

		return 1;

	}

}
?>