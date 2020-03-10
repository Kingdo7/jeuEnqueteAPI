<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\SecurityService;

class SecurityService {
    public function CheckToken($token){
        if($token != 12345){
            $response = new $response();
            $response->setContent(json_encode([
                'error'     => 'error',
                'résultat'  => false,
                'errorMessage'  => 'Le token est invalide',
            ]));
            $response->header->set('Content-Type', 'application/json');
            return $response;
        } else {
            return true;
        }
    }
}