<?php
class Route{
    protected $registry;
    protected $class_name;
    protected $method_name;
    protected $object;
    protected $data = array();
    protected $as_a_service = false;

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


        $this->as_a_service = false;

        if (isset($data[0]) && $data[0] == "as_a_service") {
            print "Script will work as a service" . PHP_EOL;
            $this->as_a_service = true;
            array_shift($data);
        }

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
                    $this->data = $data;
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }
    }

    public function run()
    {
        if ($this->as_a_service) {
            while (true) {
                call_user_func_array( array($this->object, $this->method_name ), array($this->data));
                echo PHP_EOL;
                sleep(2);
            }
        } else {
            call_user_func_array( array($this->object, $this->method_name ), array($this->data));
            echo PHP_EOL;
        }
    }

}
