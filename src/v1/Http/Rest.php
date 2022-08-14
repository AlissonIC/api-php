<?php
	namespace Api\Http;

	class Rest{
		private $request;

		private $class;
		private $method;
		private $params = array();

		public function errorMsg($code='AC000'){
			$error['AC200'] = 'Action executed successfully!';
			$error['AC500'] = 'No data received!';
			$error['AC501'] = 'Field filled in incorrectly!';
			$error['AC502'] = 'Non-existent method!';
			$error['AC503'] = 'Non-existent class!';
			$error['AC504'] = 'Database returned empty!';
			$error['AC505'] = 'Not authenticated!';
			$error['AC506'] = 'Data already exists in the database!';
			$error['AC000'] = 'Unknown error!';

			if(isset($error[$code])){
				return $error[$code];
			} else {
				return $error['AC000'];
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
				}
			}
		}

		public function run(){

			if (class_exists('\Api\Http\Controllers\\'.$this->class) && method_exists('\Api\Http\Controllers\\'.$this->class, $this->method)) {

				try {
					$controll = "\Api\Http\Controllers\\".$this->class;
					$response = call_user_func_array(array(new $controll, $this->method), $this->params);
					return json_encode(array('status' => 'sucess', 'data' => $response));
				} catch (\Exception $e) {
					$msg = $this->errorMsg($e->getMessage());
					return json_encode(array('status' => 'error', 'data' => $msg));
				}
				
			} else {

				return json_encode(array('status' => 'error', 'data' => 'Invalid Operation'));

			}
		}
	}