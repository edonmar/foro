<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Form\Type\CategoriaType;
use AppBundle\Repository\CategoriaRepository;
use AppBundle\Repository\TemaRepository;
use AppBundle\Repository\RespuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends Controller
{
    /**
     * @Route("/categorias", name="categoria_listar")
     */
    public function indexAction(CategoriaRepository $categoriaRepository, TemaRepository $temaRepository, RespuestaRepository $respuestaRepository)
    {
        $categorias = $categoriaRepository->findAll();

        $numTemas = array();
        $numRespuestas = array();
        foreach ($categorias as $categoria){
            $sum = 0;
            $temas = $temaRepository->findByCategoria($categoria);
            $numTemas[] = $temaRepository->contarPorCategoria($categoria);
            foreach ($temas as $tema){
                $sum += $respuestaRepository->contarPorTema($tema);
            }
            $numRespuestas[] = $sum;
        }

        return $this->render('categoria/listar.html.twig', [
            'categorias' => $categorias,
            'numTemas' => $numTemas,
            'numRespuestas' => $numRespuestas
        ]);
    }

    /**
     * @Route("/categoria/temas/{id}", name="categoria_temas_listar")
     */
    public function temasAction(TemaRepository $temaRepository, RespuestaRepository $respuestaRepository, Categoria $categoria)
    {
        $temas = $temaRepository->findByCategoria($categoria);

        $numRespuestas = array();
        $ultimaRespuesta = array();
        foreach ($temas as $tema) {
            $numRespuestas[] = $respuestaRepository->contarPorTema($tema);
            $ultimaRespuesta[] = $respuestaRepository->ultimaRespuesta($tema);
        }

        return $this->render('categoria/listar_temas.html.twig', [
            'temas' => $temas,
            'categoria' => $categoria,
            'numRespuestas' => $numRespuestas,
            'ultimaRespuesta' => $ultimaRespuesta
        ]);
    }

    /**
     * @Route("/categoria/{id}", name="categoria_form", methods={"GET", "POST"})
     */
    public function formAction(Request $request, Categoria $categoria)
    {
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en la categoría guardados con éxito');
                return $this->redirectToRoute('categoria_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('categoria/form.html.twig', [
            'form' => $form->createView(),
            'categoria' => $categoria
        ]);
    }
}
