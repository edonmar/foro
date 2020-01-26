<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Respuesta;
use AppBundle\Entity\Tema;
use AppBundle\Form\Type\RespuestaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RespuestaController extends Controller
{
    /**
     * @Route("/respuesta/{tema}/nueva", name="respuesta_nueva", methods={"GET", "POST"})
     */
    public function nuevaAction(Request $request, Tema $tema)
    {
        $nuevaRespuesta = new Respuesta();
        $nuevaRespuesta->setFechaCreacion(new \DateTime());
        $nuevaRespuesta->setEditada(false);
        $nuevaRespuesta->setTema($tema);
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevaRespuesta);

        return $this->formAction($request, $nuevaRespuesta);
    }

    /**
     * @Route("/respuesta/{id}", name="respuesta_form", methods={"GET", "POST"})
     */
    public function formAction(Request $request, Respuesta $respuesta)
    {
        if($respuesta->getId())
            $respuesta->setEditada(true);

        $form = $this->createForm(RespuestaType::class, $respuesta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en la respuesta guardados con éxito');
                return $this->redirectToRoute('tema_respuestas_listar', ['id' => $respuesta->getTema()->getId()]);
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('respuesta/form.html.twig', [
            'formulario' => $form->createView(),
            'respuesta' => $respuesta
        ]);
    }

    /**
     * @Route("/respuesta/eliminar/{id}", name="respuesta_eliminar", methods={"GET", "POST"})
     */
    public function eliminarAction(Request $request, Respuesta $respuesta)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($respuesta);
                $em->flush();
                $this->addFlash('success', 'Respuesta eliminada con éxito');
                return $this->redirectToRoute('tema_respuestas_listar', ['id' => $respuesta->getTema()->getId()]);
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar la respuesta');
                return $this->redirectToRoute('respuesta_form', ['id' => $respuesta->getId()]);
            }
        }
        return $this->render('respuesta/eliminar.html.twig', [
            'respuesta' => $respuesta
        ]);
    }
}
