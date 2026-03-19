<?php

require_once LIB_DIR . '/Jwt/src/BeforeValidException.php';
require_once LIB_DIR . '/Jwt/src/ExpiredException.php';
require_once LIB_DIR . '/Jwt/src/JWK.php';
require_once LIB_DIR . '/Jwt/src/JWT.php';
require_once LIB_DIR . '/Jwt/src/Key.php';
require_once LIB_DIR . '/Jwt/src/SignatureInvalidException.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtToken extends dbclass {

    const JWT_SECRET_KEY = 'oiz8HJRBMFFDxgSvLMZL23cCMwmYDSML';
    const JWT_ALGO = 'HS256';
    const EXP_TIME = 60 * 60 * 24 * 120;
    const REFRESH_TIME = 60 * 60 * 24 * 300; // FOR 30 DAYS REFRESH TOKEN

    public function validate_token() {
        $response = [];
        $headers = getallheaders();
        try {
            if (!empty($headers['Servicecall'])) {
                return $response;
            }
            if (
                    isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' &&
                    empty($headers['Login']) &&
                    empty($headers['ServiceCall'])
            ) {
                $user_id = $_SESSION['ADMIN_USER']['ID'];
                if (empty($headers['Authorization'])) {
                    throw new Exception('Unauthorized: Invalid User');
                }
                if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                    $stripped_token = $matches[1];
                    $token_info = JWT::decode($stripped_token, new Key(self::JWT_SECRET_KEY, self::JWT_ALGO));
                    $user_data = $token_info->user_data;
                    if ($user_id != $user_data->id) {
                        throw new Exception('Unauthorized: Invalid User');
                    }
                } else {
                    throw new Exception('Unauthorized: Invalid User');
                }
            }
        } catch (Exception $exc) {
            if ($exc->getMessage() == "Expired token") {
                try {
                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && empty($headers['Login'])) {
                        $user_id = $_SESSION['ADMIN_USER']['ID'];
                        $query = "SELECT token FROM admin WHERE id = {$user_id}";
                        $result = $this->fetchRow($query);
                        if ($result) {
                            $token = $result['token'];
                            if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
                                $stripped_token = $matches[1];
                                $token_info = JWT::decode($stripped_token, new Key(self::JWT_SECRET_KEY, self::JWT_ALGO));
                                $user_data = $token_info->user_data;
                                if ($user_id != $user_data->id) {
                                    throw new Exception('Unauthorized: Invalid User');
                                }
                                $user_data_array = json_decode(json_encode($user_data), true);
                                $_SESSION['new_token'] = self::generate_token($user_data_array);
                            }
                        }
                    }
                } catch (Exception $e) {
                    $response['error'] = 401;
                    $response['message'] = 'Unauthorized: Session Timeout';
                    return $response;
                }
            } else {
                $response['error'] = 401;
                $response['message'] = 'Unauthorized: Invalid Token';
                return $response;
            }
            exit;
        }
    }

    public function generate_token($user_data) {
        $payload = [];
        $time = time();
        $expirationTime = $time + self::EXP_TIME;
        $payload['iat'] = $time;
        $payload['nbf'] = $time;
        $payload['exp'] = $expirationTime;
        $payload['user_data'] = $user_data;
        $access_token = JWT::encode($payload, self::JWT_SECRET_KEY, self::JWT_ALGO);
        $expirationTimeRefresh = $time + self::REFRESH_TIME;
        $payload['exp'] = $expirationTimeRefresh;
        // Save Refresh Token
        $data['token'] = JWT::encode($payload, self::JWT_SECRET_KEY, self::JWT_ALGO);
        $this->_update('admin', $data, array('id' => $user_data['id']));
        return $access_token;
    }
}
