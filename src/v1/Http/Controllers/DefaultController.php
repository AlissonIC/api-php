<?php
	namespace Api\Http\Controllers;

	class DefaultController {

		public function Show($parameters = array(''), $get = array(''), $post= array('')) {      
			if (AuthController::checkAuth()){
				throw new \Exception('', '000'); // Exemple of return if user is logged
			} else {
				throw new \Exception('', '505');
			}
		}

		public function Add($parameters = array(''), $get = array(''), $post= array('')) {
			if (AuthController::checkAuth()){
                
				$required = ["name", "document", "birthday", "company", "mail", "password"];
				if (AuthController::checkReceived($required, $post)){
                    throw new \Exception('', '000'); // Exemple of return if user is logged
                }

			} else {
				throw new \Exception('', '505');
			}
		}

		public function Edit($parameters = array(''), $get = array(''), $post= array('')) {    
			if (AuthController::checkAuth()){
				throw new \Exception('', '000'); // Exemple of return if user is logged
			} else {
				throw new \Exception('', '505');
			}
		}

		public function Del($parameters = array(''), $get = array(''), $post= array('')) {   
			if (AuthController::checkAuth()){
				throw new \Exception('', '000'); // Exemple of return if user is logged
			} else {
				throw new \Exception('', '505');
			}
		}

	}