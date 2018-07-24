<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Document\Product;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $db = $this->get('doctrine_mongodb')->getManager()->getRepository(Product::class);

        $product = $db->find('5b55c163e05f064fc0001670');

        print_r($product->getName());

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
