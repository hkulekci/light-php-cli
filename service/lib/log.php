<?php 
class Log {
	private $filename;
	
	public function __construct($filename) {
		$this->filename = $filename;
	}
	
	public function write($message) {
		$file = DIR_LOGS . $this->filename;
		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, date('Y-m-d G:i:s') . ' - ' . $message . "\n");
			
		fclose($handle); 
	}

	public function error_handler($errno, $errstr, $errfile, $errline) {
		//global $log;
		
		switch ($errno) {
			case E_NOTICE:
			case E_USER_NOTICE:
				$error = 'Notice';
				break;
			case E_WARNING:
			case E_USER_WARNING:
				$error = 'Warning';
				break;
			case E_ERROR:
			case E_USER_ERROR:
				$error = 'Fatal Error';
				break;
			default:
				$error = 'Unknown';
				break;
		}
		
		if (ERROR_DISPLAY)
			echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';

		if (ERROR_LOG)
			$this->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);

		return true;
	}
}
?>