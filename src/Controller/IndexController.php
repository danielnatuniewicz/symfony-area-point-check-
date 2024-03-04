<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Helper\AreaHelper;

class IndexController extends AbstractController
{
    public function __construct(AreaHelper $areaHelper)
    {
        $this->areaHelper = $areaHelper;
    }

    public function index(): Response
    {
        return $this->render('index/index.html.twig', ['area' => $this->areaHelper->getArea()]);
    }
}
