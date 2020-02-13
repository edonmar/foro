<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tema;
use AppBundle\Entity\Categoria;
use AppBundle\Form\Type\TemaType;
use AppBundle\Repository\TemaRepository;
use AppBundle\Repository\RespuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TemaController extends Controller
{
    /**
     * @Route("/tema/respuestas/{id}", name="tema_respuestas_listar")
     */
    public function respuestasAction(RespuestaRepository $respuestaRepository, TemaRepository $temaRepository, Tema $tema)
    {
        $usuario = $tema->getUsuario();
        $numAportesAutorTema = $temaRepository->contarPorUsuario($usuario) + $respuestaRepository->contarPorUsuario($usuario);

        $respuestas = $respuestaRepository->findByTema($tema);
        $numAportesAutorRespuesta = array();
        foreach ($respuestas as $respuesta) {
            $usuario = $respuesta->getUsuario();
            $numAportesAutorRespuesta[] = $temaRepository->contarPorUsuario($usuario) + $respuestaRepository->contarPorUsuario($usuario);
        }

        return $this->render('tema/listar_respuestas.html.twig', [
            'respuestas' => $respuestas,
            'tema' => $tema,
            'numAportesAutorTema' => $numAportesAutorTema,
            'numAportesAutorRespuesta' => $numAportesAutorRespuesta
        ]);
    }

    /**
     * @Route("/tema/{categoria}/nuevo", name="tema_nuevo", methods={"GET", "POST"})
     */
    public function nuevaAction(Request $request, Categoria $categoria)
    {
        $nuevoTema = new Tema();
        $nuevoTema->setFechaCreacion(new \DateTime());
        $nuevoTema->setEditado(false);
        $nuevoTema->setCategoria($categoria);
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevoTema);

        return $this->formAction($request, $nuevoTema);
    }

    /**
     * @Route("/tema/{id}", name="tema_form", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function formAction(Request $request, Tema $tema)
    {
        if($tema->getId())
            $tema->setEditado(true);

        $form = $this->createForm(TemaType::class, $tema, [
            'nuevo' => $tema->getId() === null
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en el tema guardados con éxito');
                return $this->redirectToRoute('tema_respuestas_listar', ['id' => $tema->getId()]);
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('tema/form.html.twig', [
            'formulario' => $form->createView(),
            'tema' => $tema
        ]);
    }

    /**
     * @Route("/tema/eliminar/{id}", name="tema_eliminar", methods={"GET", "POST"})
     */
    public function eliminarAction(Request $request, Tema $tema)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($tema);
                $em->flush();
                $this->addFlash('success', 'Tema eliminado con éxito');
                return $this->redirectToRoute('categoria_temas_listar', ['id' => $tema->getCategoria()->getId()]);
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar el tema');
                return $this->redirectToRoute('tema_form', ['id' => $tema->getId()]);
            }
        }
        return $this->render('tema/eliminar.html.twig', [
            'tema' => $tema
        ]);
    }
}
