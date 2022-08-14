<?php
	namespace Api\Http;

	class Rest{
		private $request;

		private $class;
		private $method;
		private $params = array();

		public function errorMsg($code='AC000'){
			$error['AC200'] = 'Ação executada com sucesso!';
			$error['AC500'] = 'Nenhum dado recebido!';
			$error['AC501'] = 'Campo prenchido de forma incorreta!';
			$error['AC502'] = 'Metodo inexistente!';
			$error['AC503'] = 'Classe inexistente!';
			$error['AC504'] = 'Banco de dados retornou vazio!';
			$error['AC505'] = 'Não autenticado!';
			$error['AC506'] = 'Dado ja existe no bando de dados!';
			$error['AC000'] = 'Erro desconhecido!';

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

				return json_encode(array('status' => 'error', 'data' => 'Operação Inválida'));

			}
		}
	}