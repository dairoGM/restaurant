<?php

namespace App\Services\Chat;

class AlgPassEncrypt
{
    
    public static function generarPassword() : string
    {       
        return "M8rmM6YnnkJqGJi.2022";
    }  

    public static function encodePassowrd($password, $alg)
    {        
        switch ($alg)
        {
            case AlgPassEncrypt::$ALG_SMPLTXT : 
                return AlgPassEncrypt::encodeSMPLTXT($password);

            default:
                return AlgPassEncrypt::encodeSMPLTXT($password);  

        }
    }

    public static function decodePassowrd($password, $alg)
    {
        switch ($alg)
        {
            case AlgPassEncrypt::$ALG_SMPLTXT : 
                return AlgPassEncrypt::decodeSMPLTXT($password);

            default:
                return AlgPassEncrypt::decodeSMPLTXT($password);  

        }
    }


    //Alg SMPLTXT
    public static $ALG_SMPLTXT = "SMPLTXT";

    private static function encodeSMPLTXT($password)
    {
        return $password;
    }

    private static function decodeSMPLTXT($password)
    {
        return $password;
    }
}