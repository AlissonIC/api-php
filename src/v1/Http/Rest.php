<?php
	namespace Api\Http;

	class Rest{
		private $request;

		private $class;
		private $method;
		private $params = array();

		public function errorMsg($code='000', $required=''){
			$error['200'] = 'Action executed successfully!';
			$error['500'] = 'Please make sure you pass the following parameter(s):';
			$error['501'] = 'Field filled in incorrectly!';
			$error['502'] = 'Non-existent method!';
			$error['503'] = 'Non-existent class!';
			$error['504'] = 'Database returned empty!';
			$error['505'] = 'Not authenticated!';
			$error['506'] = 'Data already exists in the database!';
			$error['507'] = 'Database connection failed!';
			$error['000'] = 'Unknown error!';

			if(isset($error[$code])){
				if($code == 500){
					return $error[$code]." ".$required;
				}
				return $error[$code];
			} else {
				return $error['000'];
			}
		}

		public function __construct($req) {
			$this->request = $req;
			$this->load();
		}

		public function load(){
			$newUrl = explode('/', $this->request['url']);
			array_shift($newUrl);

			if (isset($newUrl[0])) {
				$this->class = ucfirst($newUrl[0]).'Controller';
				array_shift($newUrl);

				if (isset($newUrl[0])) {
					$this->method = $newUrl[0];
					array_shift($newUrl);

					if (isset($newUrl[0])) {
						$this->params = $newUrl;
					}

					$this->get = $_GET;
					$this->post = $_POST;
				}
			}
		}

		public function run(){

			if (class_exists('\Api\Http\Controllers\\'.$this->class) && method_exists('\Api\Http\Controllers\\'.$this->class, $this->method)) {

				try {
					$controll = "\Api\Http\Controllers\\".$this->class;
					$response = call_user_func_array(array(new $controll, $this->method), array($this->params, $this->get, $this->post));
					return json_encode(array('status' => 'sucess', 'data' => $response));
				} catch (\Exception $e) {
					$info = $this->errorMsg($e->getCode(), $e->getMessage());
					return json_encode(array('status' => 'error', 'data' => $info));
				}
				
			} else {

				return json_encode(array('status' => 'error', 'data' => 'Invalid Operation'));

			}
		}
	}