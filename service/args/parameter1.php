<?php  
class parameter1 extends Controller{
	
	public function index($data = array()){

		echo 'parameter1 file index method is runned! Args : '.serialize($data) . PHP_EOL;
		return 1;

	}

	public function run($data = array()){

		$this->db->query("INSERT INTO test SET test = 'test_message'");
		echo 'parameter1 file run method is runned! Args : '.serialize($data) . PHP_EOL;
		return 1;

	}

}
?>