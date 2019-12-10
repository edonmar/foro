<?php

namespace AppBundle\Controller;

use AppBundle\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends Controller
{
    /**
     * @Route("/categorias", name="categoria_listar")
     */
    public function indexAction(CategoriaRepository $categoriaRepository)
    {
        $categorias = $categoriaRepository->findAll();

        return $this->render('categoria/listar.html.twig', [
            'categorias' => $categorias
        ]);
    }
}
