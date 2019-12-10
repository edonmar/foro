<?php

namespace AppBundle\Controller;

use AppBundle\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuarios", name="usuario_listar")
     */
    public function indexAction(UsuarioRepository $usuarioRepository)
    {
        $usuarios = $usuarioRepository->findTodosOrdenados();

        return $this->render('usuario/listar.html.twig', [
            'usuarios' => $usuarios
        ]);
    }
}
