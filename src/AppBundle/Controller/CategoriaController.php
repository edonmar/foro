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

        $numRespuestas = array();
        $ultimaRespuesta = array();
        foreach ($categorias as $categoria){
            $numRespuestas[] = $respuestaRepository->contarPorCategoria($categoria);
            $ultimaRespuesta[] = $respuestaRepository->ultimaRespuestaCategoria(($categoria));
        }

        return $this->render('categoria/listar.html.twig', [
            'categorias' => $categorias,
            'numRespuestas' => $numRespuestas,
            'ultimaRespuesta' => $ultimaRespuesta
        ]);
    }

    /**
     * @Route("/categoria/temas/{id}", name="categoria_temas_listar")
     */
    public function temasAction(TemaRepository $temaRepository, RespuestaRepository $respuestaRepository, Categoria $categoria)
    {
        $temas = $temaRepository->findByCategoria($categoria);

        $ultimaRespuesta = array();
        foreach ($temas as $tema) {
            $ultimaRespuesta[] = $respuestaRepository->ultimaRespuestaTema($tema);
        }

        return $this->render('categoria/listar_temas.html.twig', [
            'temas' => $temas,
            'categoria' => $categoria,
            'ultimaRespuesta' => $ultimaRespuesta
        ]);
    }

    /**
     * @Route("/categoria/nueva", name="categoria_nueva", methods={"GET", "POST"})
     */
    public function nuevaAction(Request $request)
    {
        $nuevaCategoria = new Categoria();
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevaCategoria);

        return $this->formAction($request, $nuevaCategoria);
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

    /**
     * @Route("/categoria/eliminar/{id}", name="categoria_eliminar", methods={"GET", "POST"})
     */
    public function eliminarAction(Request $request, Categoria $categoria)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($categoria);
                $em->flush();
                $this->addFlash('success', 'Categoría eliminada con éxito');
                return $this->redirectToRoute('categoria_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar la categoría. Puede que no se pueda eliminar porque tiene contenido.');
                return $this->redirectToRoute('categoria_form', ['id' => $categoria->getId()]);
            }
        }
        return $this->render('categoria/eliminar.html.twig', [
            'categoria' => $categoria
        ]);
    }
}
