<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Response;

class JWTService
{
    private $secretKey;

    public function __construct()
    {
        $this->secretKey = config('jwt.secret');
    }

    public function decodeToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return [
                'status' => 'success',
                'data' => $decoded
            ];
        } catch (ExpiredException $e) {
            return [
                'status' => 'error',
                'error' => 'token_expired',
                'message' => 'Thời gian sống của token đã hết.',
                'code' => Response::HTTP_REQUEST_TIMEOUT
            ];
        } catch (BeforeValidException $e) {
            return [
                'status' => 'error',
                'error' => 'token_invalid',
                'message' => 'Token không hợp lê.',
                'code' => Response::HTTP_REQUEST_TIMEOUT
            ];
        } catch (SignatureInvalidException $e) {
            return [
                'status' => 'error',
                'error' => 'token_invalid',
                'message' => 'Token không hợp lệ.',
                'code' => Response::HTTP_REQUEST_TIMEOUT
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'error' => 'token_invalid',
                'message' => 'Token không hợp lệ.',
                'code' => Response::HTTP_REQUEST_TIMEOUT
            ];
        }
    }
}
