<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tema;
use AppBundle\Repository\TemaRepository;
use AppBundle\Repository\RespuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}
