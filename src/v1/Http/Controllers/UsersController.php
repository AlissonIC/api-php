<?php
	namespace Api\Http\Controllers;

	class UsersController {

		public function Show($parameters = array(''), $get = array(''), $post= array('')) {            
			if (AuthController::checkAuth()) {                 
                //Connects to database
                include(__DIR__ . '/../../classes/data_connection.php');

                //Execute
                $sql = isset($_POST['id']) && !empty($_POST['id']) ? "AND `id` = ".$_POST['id'] : "";
                $sql = "SELECT * FROM `users` WHERE `type` = 2 ".$sql." ORDER BY `id` DESC";
                $sql = $con->prepare($sql);
                $sql->execute();
                $resut = $sql->fetchAll();

                //Checks whether the return is empty
                if (!empty($resut)) { return $resut; } else { throw new \Exception('', '504'); }
			} else {
				throw new \Exception('', '505');
			}
		}

		public function Add($parameters = array(''), $get = array(''), $post= array('')) {         
			if (AuthController::checkAuth()) {
				if (isset($_POST['document'], $_POST['name'], $_POST['mail'], $_POST['password'])){
                    //Connects to database
                    include(__DIR__ . '/../../classes/data_connection.php');
    
                    //Execute
                    $sql = "INSERT INTO `users` (`document`, `name`, `mail`, `password`) VALUES ('".$_POST['document']."', '".$_POST['name']."', '".$_POST['mail']."', '".md5($_POST['password'])."')";
                    $sql = $con->prepare($sql);
                    $sql->execute();
    
                    //Checks whether the return is empty
                    if ($sql->rowCount() > 0) { return true; } else { throw new \Exception('', '504'); }
                } else{
					throw new \Exception('', '500');
				}	    
			} else {
				throw new \Exception('', '505');
			}
		}

		public function Edit($parameters = array(''), $get = array(''), $post= array('')) {         
			if (AuthController::checkAuth()) {
				if (isset($_POST['id'], $_POST['document'], $_POST['name'], $_POST['mail'], $_POST['password'])){
                    //Connects to database
                    include(__DIR__ . '/../../classes/data_connection.php');
    
                    //Execute
                    $passEdit = isset($_POST['password']) && !empty($_POST['password']) ? ", `password` = '".$_POST['password']."'" : "";
                    $sql = "UPDATE `users` SET `document` = '".$_POST['document']."', `name` = '".$_POST['name']."', `mail` = '".$_POST['mail']."'".$passEdit." WHERE `id` = ".$_POST['id'];
                    $sql = $con->prepare($sql);
                    $sql->execute();
    
                    //Checks whether the return is empty
                    if ($sql->rowCount() > 0) { return true; } else { throw new \Exception('', '504'); }

                } else{
					throw new \Exception('', '500');
				}	 
			} else {
				throw new \Exception('', '505');
			}
		}

		public function Del($parameters = array(''), $get = array(''), $post= array('')) {         
			if (AuthController::checkAuth()) {
				if (isset($_POST['id'])){
                    //Connects to database
                    include(__DIR__ . '/../../classes/data_connection.php');
    
                    //Execute
                    $sql = "DELETE FROM `users` WHERE `id` = ".$_POST['id'];
                    $sql = $con->prepare($sql);
                    $sql->execute();
    
                    //Checks whether the return is empty
                    if ($sql->rowCount() > 0) { return true; } else { throw new \Exception('', '504'); }
                } else{
					throw new \Exception('', '500');
				}	 
			} else {
				throw new \Exception('', '505');
			}
		}

	}