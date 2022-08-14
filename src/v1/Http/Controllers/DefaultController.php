<?php
	namespace Api\Http\Controllers;

	class DefaultController {

		public function Show($parameters = null) {      
			if (AuthController::checkAuth()){
				throw new \Exception('AC000'); // Exemple of return if user is logged
			} else {
				throw new \Exception('AC505');
			}
		}

		public function Add($parameters = null) {
			if (AuthController::checkAuth()){
				throw new \Exception('AC000'); // Exemple of return if user is logged
			} else {
				throw new \Exception('AC505');
			}
		}

		public function Edit($parameters = null) {    
			if (AuthController::checkAuth()){
				throw new \Exception('AC000'); // Exemple of return if user is logged
			} else {
				throw new \Exception('AC505');
			}
		}

		public function Del($parameters = null) {   
			if (AuthController::checkAuth()){
				throw new \Exception('AC000'); // Exemple of return if user is logged
			} else {
				throw new \Exception('AC505');
			}
		}

	}