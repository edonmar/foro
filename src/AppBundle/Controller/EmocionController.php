<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emocion;
use AppBundle\Form\Type\EmocionType;
use AppBundle\Repository\EmocionRepository;
use AppBundle\Repository\TemaRepository;
use AppBundle\Repository\RespuestaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EmocionController extends Controller
{
    /**
     * @Route("/emociones", name="emocion_listar")
     */
    public function indexAction(EmocionRepository $emocionRepository)
    {
        $emociones = $emocionRepository->findAll();

        return $this->render('emocion/listar.html.twig', [
            'emociones' => $emociones
        ]);
    }

    /**
     * @Route("/emocion/temas/{id}", name="emocion_temas_listar")
     */
    public function temasAction(TemaRepository $temaRepository, RespuestaRepository $respuestaRepository, Emocion $emocion)
    {
        $temas = $temaRepository->findByEmocion($emocion);

        $ultimaRespuesta = array();
        foreach ($temas as $tema) {
            $ultimaRespuesta[] = $respuestaRepository->ultimaRespuestaTema($tema);
        }

        return $this->render('emocion/listar_temas.html.twig', [
            'temas' => $temas,
            'emocion' => $emocion,
            'ultimaRespuesta' => $ultimaRespuesta
        ]);
    }

    /**
     * @Route("/emocion/nueva", name="emocion_nueva", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function nuevaAction(Request $request)
    {
        $nuevaEmocion = new Emocion();
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevaEmocion);

        return $this->formAction($request, $nuevaEmocion);
    }

    /**
     * @Route("/emocion/{id}", name="emocion_form", requirements={"id"="\d+"}, methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formAction(Request $request, Emocion $emocion)
    {
        $form = $this->createForm(EmocionType::class, $emocion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en la emoción guardados con éxito');
                return $this->redirectToRoute('emocion_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('emocion/form.html.twig', [
            'formulario' => $form->createView(),
            'emocion' => $emocion
        ]);
    }

    /**
     * @Route("/emocion/eliminar/{id}", name="emocion_eliminar", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function eliminarAction(Request $request, Emocion $emocion)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($emocion);
                $em->flush();
                $this->addFlash('success', 'Emoción eliminada con éxito');
                return $this->redirectToRoute('emocion_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar la emoción');
                return $this->redirectToRoute('emocion_form', ['id' => $emocion->getId()]);
            }
        }
        return $this->render('emocion/eliminar.html.twig', [
            'emocion' => $emocion
        ]);
    }
}
