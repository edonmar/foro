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
    public function respuestasAction(RespuestaRepository $respuestaRepository, Tema $tema)
    {
        $respuestas = $respuestaRepository->findByTema($tema);

        return $this->render('tema/listar_respuestas.html.twig', [
            'respuestas' => $respuestas,
            'tema' => $tema
        ]);
    }
}
