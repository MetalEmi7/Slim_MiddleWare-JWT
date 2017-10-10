<?php
require_once '../composer/vendor/autoload.php';
use Firebase\JWT\JWT;

class AuthJWT
{
    private static $key = 'ClaveSuperSecreta@';
    private static $encType = ['HS256'];
    private static $aud = null;

    public static function getToken($data)
    {
        $now = time();
        /*
         parametros del payload
         https://tools.ietf.org/html/rfc7519#section-4.1
         */
        $payload = array(
            'iat' => $now,      
            'aud' => self::Aud(),
            'data' => $data,
            'app' => "Generic User APIREST"
        );

        return JWT::encode($payload, self::$key);
    }

    public static function verifyToken($token)
    {
        $rv = true;
        if (empty($token) || $token == "")
            {
            $rv = false;
        }
        try {
            $decodificado = JWT::decode(
                $token,
                self::$key,
                self::$encType
            );
            if ($decodificado->aud !== self::Aud())
                {
                $rv = false;
            }
        } catch (Exception $ex) {
            $rv = false;
        }
        // si no da error,  verifico los datos de AUD que uso para saber de que lugar viene  

        return $rv;
    }


    public static function ObtenerPayLoad($token)
    {
        return JWT::decode(
            $token,
            self::$key,
            self::$encType
        );
    }
    public static function ObtenerData($token)
    {
        return JWT::decode(
            $token,
            self::$key,
            self::$encType
        )->data;
    }
    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}