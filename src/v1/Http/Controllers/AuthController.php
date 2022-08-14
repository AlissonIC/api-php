<?php
    namespace Api\Http\Controllers;
    
    class AuthController {
        public function login(){
            
            if (isset($_POST['mail'], $_POST['password'])) {

                $ip = isset($_SERVER['HTTP_CLIENT_IP']) 
                    ? $_SERVER['HTTP_CLIENT_IP'] 
                    : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
                    ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
                    : $_SERVER['REMOTE_ADDR']);

                //Connects to database
                include(__DIR__ . '/../../classes/data_connection.php');

                //Execute
                // $loginpass = "SELECT COUNT(*) FROM `users` WHERE `mail` = '".$_POST['mail']."' AND `password` = '".$_POST['password']."' LIMIT 1";
                $loginpass = "UPDATE `users` SET `last_ip`='".$ip."', `last_login`= NOW() WHERE `mail` = '".$_POST['mail']."' AND `password` = '".$_POST['password']."'";
                $loginpass = $con->prepare($loginpass);
                $loginpass->execute();
                $loginpass->rowCount();
                // $passresult = $loginpass->fetchColumn();

                if ($loginpass->rowCount() == "1") {

                    $iduser = "SELECT * FROM `users` WHERE `mail` = '".$_POST['mail']."' AND `password` = '".$_POST['password']."' LIMIT 1";
                    $data = $con->prepare($iduser);
                    $data->execute();
                    $datauser = $data->fetch();

                    //Application Key
                    $key = 'u9egTjcWPDEBo';

                    //Header Token
                    $header = [
                        'typ' => 'JWT',
                        'alg' => 'HS256'
                    ];

                    //Payload - Content
                    $payload = [
                        'name' => $datauser['name'],
                        'mail' => $datauser['mail'],
                        'id' => $datauser['id']
                    ];

                    //JSON
                    $header = json_encode($header);
                    $payload = json_encode($payload);

                    //Base 64
                    $header = base64_encode($header);
                    $payload = base64_encode($payload);

                    //Sign
                    $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
                    $sign = base64_encode($sign);

                    //Token
                    $token = $header . '.' . $payload . '.' . $sign;

                    $result['token'] = $token;
                    $result['id'] = $datauser['id'];
                    $result['name'] = $datauser['name'];
                    $result['mail'] = $datauser['mail'];
                    $result['type'] = $datauser['type'];
                    $result['login'] = true;

                    return $result;

                } else {
                    throw new \Exception('', '501');
                }
            } else {
                throw new \Exception('', '500');
            }

        }

        public static function checkAuth(){

            $http_header = apache_request_headers();
            $bearer = isset($http_header['Authorization']) ? explode(' ', $http_header['Authorization']) : "";
            $bearer = isset($_POST['Authorization']) && !empty($_POST['Authorization']) ? explode(' ', $_POST['Authorization']) : $bearer;

            if (isset($bearer[1]) && !empty($bearer[1])) {
                
                // $bearer[0] = 'bearer';
                // $bearer[1] = 'token jwt';

                $token = explode('.', $bearer[1]);     
                if(!isset($token[1])){ return false; }
                $header = $token[0];
                $payload = $token[1];
                $sign = str_replace("\\", "", $token[2]);      

                // Check Subscription
                $valid = hash_hmac('sha256', $header . "." . $payload, 'u9egTjcWPDEBo', true);
                $valid = base64_encode($valid);

                if ($sign == $valid) {
                    return true;
                }
            }

            return false;
        } 

        public static function checkReceived($required = array(''), $parameters = array('')){
            $not_received = array('');
            foreach ($required as $k => $v) {
                if(!isset($parameters[$v]) || empty($parameters[$v])){
                    array_push($not_received, $v);
                }
            }
            $not_received = array_filter($not_received);

            if(!empty($not_received)){
                throw new \Exception(implode(", ", $not_received), '500');
            }
            return true;
        }
    }