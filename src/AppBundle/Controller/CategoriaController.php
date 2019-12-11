<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Repository\CategoriaRepository;
use AppBundle\Repository\TemaRepository;
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

    /**
     * @Route("/categoria/temas/{id}", name="categoria_temas_listar")
     */
    public function temasAction(TemaRepository $temaRepository, Categoria $categoria)
    {
        $temas = $temaRepository->findByCategoria($categoria);

        return $this->render('categoria/listar_temas.html.twig', [
            'temas' => $temas,
            'categoria' => $categoria
        ]);
    }
}
