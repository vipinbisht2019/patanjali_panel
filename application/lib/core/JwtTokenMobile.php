<?php

require_once LIB_DIR . '/Jwt/src/BeforeValidException.php';
require_once LIB_DIR . '/Jwt/src/ExpiredException.php';
require_once LIB_DIR . '/Jwt/src/JWK.php';
require_once LIB_DIR . '/Jwt/src/JWT.php';
require_once LIB_DIR . '/Jwt/src/Key.php';
require_once LIB_DIR . '/Jwt/src/SignatureInvalidException.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtTokenMobile extends dbclass {

    const JWT_SECRET_KEY = 'oiz8HJRBMFFDxgSvLMZL23cCMwmYDSML';
    const JWT_ALGO = 'HS256';
    const EXP_TIME = 60 * 60 * 24 * 120;
    const REFRESH_TIME = 60 * 60 * 24 * 300; // FOR 30 DAYS REFRESH TOKEN

    public function generate_token($user_data) {
        $payload = [];
        $time = time();
        $expirationTime = $time + self::EXP_TIME;
        $payload['user_data'] = $user_data;
        $payload['iat'] = $time;
        $payload['nbf'] = $time;
        $payload['exp'] = $expirationTime;
        $access_token = JWT::encode($payload, self::JWT_SECRET_KEY, self::JWT_ALGO);
        $expirationTimeRefresh = $time + self::REFRESH_TIME;
        $payload['exp'] = $expirationTimeRefresh;
        $data['token'] = JWT::encode($payload, self::JWT_SECRET_KEY, self::JWT_ALGO);
        $this->_update('users', $data, array('id' => $user_data['id']));
        return $access_token;
    }

    public function validate_token() {
        $headers = getallheaders();
        $response = [];
        $user_id = 0;
        try {
            if (!empty($headers['Servicecall']) || !empty($headers['ServiceCall']) ) {
                return $response;
            }
            if (empty($headers['Authorization'])) {
                throw new Exception('Unauthorized: Invalid User');
            }
            if(!empty($headers['Userid'])){
                $user_id = $headers['Userid'];
            } elseif(!empty($headers['UserId'])){
                $user_id = $headers['UserId'];
            } elseif(!empty($headers['userId'])){
                $user_id = $headers['userId'];
            }else{
                throw new Exception('Unauthorized: Invalid User');
            }
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                $stripped_token = $matches[1];
                $token_info = JWT::decode($stripped_token, new Key(self::JWT_SECRET_KEY, self::JWT_ALGO));
                $user_data = $token_info->user_data;
                if ($user_id != $user_data->id) {
                    throw new Exception('Unauthorized: Invalid User');
                }
                return $response;
            } else {
                throw new Exception('Unauthorized: Invalid User');
            }
        } catch (Exception $exc) {
            if ($exc->getMessage() == "Expired token") {
                try {
                    $payload = [];
                    $response = [];
                    $query = "SELECT token FROM users WHERE id = {$user_id}";
                    $result = $this->fetchRow($query);
                    if ($result) {
                        $token = $result['token'];
                        $token_info = JWT::decode($token, new Key(self::JWT_SECRET_KEY, self::JWT_ALGO));
                        $user_data = $token_info->user_data;
                        if ($user_id != $user_data->id) {
                            throw new Exception('Unauthorized: Invalid User');
                        }
                        $user_data_array = json_decode(json_encode($user_data), TRUE);
                        $access_token = self::generate_token($user_data_array);
                        return ['access_token' => $access_token];
                    } else {
                        throw new Exception('Unauthorized: Invalid User');
                    }
                } catch (Exception $e) {
                    $response['error'] = 200;
                    $response['token_expired'] = true;
                    return $response;
                }
            } else {
                $response['error'] = 401;
                $response['message'] = 'Unauthorized: Session Timeout';
                return $response;
            }
            exit;
        }
    }
}
