<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Helper\AreaHelper;
use App\Helper\InputValidator;

class CheckController extends AbstractController
{
    public function __construct(AreaHelper $areaHelper, InputValidator $validator)
    {
        $this->areaHelper = $areaHelper;
        $this->validator = $validator;
    }

    public function check(Request $request): JsonResponse
    {
        try{
            $this->validator->validateLatOrFail($request->request->get('lat'));
            $this->validator->validateLngOrFail($request->request->get('lng'));

            $area = $this->areaHelper->getArea();

            $countArea = count($area);
            $j = $countArea - 1;
            $inside = false;
            
            $latitude = $request->request->get('lat');
            $longitude = $request->request->get('lng');

            for($i = 0; $i < $countArea; $i++){
                if((($area[$i][1] <= $longitude) && ($longitude < $area[$j][1])) || (($area[$j][1] <= $longitude) && ($longitude < $area[$i][1]))) {
                    if ($latitude < ($area[$j][0] - $area[$i][0]) * ($longitude - $area[$i][1]) / ($area[$j][1] - $area[$i][1]) + $area[$i][0]) {
                        $inside = !$inside;
                    }
                }
                $j = $i;
            }

            $array = array(
                'status' => 'ok',
                'inside' => $inside
            );

            return new JsonResponse($array);
        }catch (\Exception $e) {
            $array = array(
                'status' => false,
                'inside' => false,
                'message' => $e->getMessage() //here you should validate server output
            );
            return new JsonResponse($array);
        }
    }
}
