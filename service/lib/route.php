<?php
class Route{
	protected $registry;
	protected $class_name;
	protected $method_name;
	protected $object;
	protected $data = array();

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

	public function prepare($data = array()){

		// to remove filename
		array_shift($data);
		if (isset( $data[0] )){

			$this->class_name = $data[0];
			array_shift($data);

			if (is_file( ROOT_DIR."args/" . $this->class_name . ".php" )){

				include_once ROOT_DIR."args/" . $this->class_name . ".php";

				if (isset( $data[0] )){
					$this->method_name = $data[0];
					array_shift($data);
				}else{
					$this->method_name = 'index';
				}

				if (is_callable( array( $this->class_name, $this->method_name ) )){

					$this->object = new $this->class_name($this->registry);
					$ret = call_user_func_array( array($this->object, $this->method_name ), array($data));

					return $ret;

				}else{

					return 0;

				}

			}else{

				return 0;

			}

		}
	}

}