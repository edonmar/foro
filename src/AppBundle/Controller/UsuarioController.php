<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Repository\UsuarioRepository;
use AppBundle\Repository\TemaRepository;
use AppBundle\Repository\RespuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuarios", name="usuario_listar")
     */
    public function indexAction(TemaRepository $temaRepository, RespuestaRepository $respuestaRepository, UsuarioRepository $usuarioRepository)
    {
        $usuarios = $usuarioRepository->findTodosOrdenados();

        $numAportes = array();
        foreach ($usuarios as $usuario) {
            $numAportes[] = $temaRepository->contarPorUsuario($usuario) + $respuestaRepository->contarPorUsuario($usuario);
        }

        return $this->render('usuario/listar.html.twig', [
            'usuarios' => $usuarios,
            'numAportes' => $numAportes
        ]);
    }

    /**
     * @Route("/usuario/detalles/{id}", name="usuario_detalles")
     */
    public function usuarioAction(TemaRepository $temaRepository, RespuestaRepository $respuestaRepository, Usuario $usuario)
    {
        $temas = $temaRepository->findByUsuario($usuario);
        $respuestas = $respuestaRepository->findByUsuario($usuario);

        return $this->render('usuario/detalles_usuario.html.twig', [
            'temas' => $temas,
            'respuestas' => $respuestas,
            'usuario' => $usuario
        ]);
    }
}
