<?php 
namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;

class InputValidator
{
    public function validateLatOrFail($lat)
    {
        if (!isset($lat)) {
            throw new \Exception('Latitude not found', Response::HTTP_CONFLICT);
        }

        if(empty($lat)){
            throw new \Exception('Latitude not found', Response::HTTP_CONFLICT);
        }
    
        return true;
    }

    public function validateLngOrFail($lng)
    {
        if (!isset($lng)) {
            throw new \Exception('Longitude not found', Response::HTTP_CONFLICT);
        }

        if (empty($lng)) {
            throw new \Exception('Longitude not found', Response::HTTP_CONFLICT);
        }
    
        return true;
    }    
}