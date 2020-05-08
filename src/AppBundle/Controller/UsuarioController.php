<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Model\CambioClave;
use AppBundle\Form\Type\CambioClaveType;
use AppBundle\Form\Type\MiUsuarioType;
use AppBundle\Form\Type\UsuarioType;
use AppBundle\Repository\UsuarioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsuarioController extends Controller
{
    /**
     * @Route("/usuarios/{filtro}", name="usuario_listar", requirements={"filtro": "0|1|2"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction(UsuarioRepository $usuarioRepository, $filtro = 0)
    {
        switch ($filtro) {
            case 0:
                $usuarios = $usuarioRepository->findTodosOrdenados();
                break;
            case 1:
                $usuarios = $usuarioRepository->findConPermisosOrdenados();
                break;
            case 2:
                $usuarios = $usuarioRepository->findSinPermisosOrdenados();
                break;
        }

        return $this->render('usuario/listar.html.twig', [
            'usuarios' => $usuarios,
            'filtro' => $filtro
        ]);
    }

    /**
     * @Route("/usuario/detalles/{id}", name="usuario_detalles")
     * @Security("is_granted('ROLE_USER')")
     */
    public function usuarioAction(Usuario $usuario)
    {
        return $this->render('usuario/detalles_usuario.html.twig', [
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/usuario/nuevo", name="usuario_nuevo", methods={"GET", "POST"})
     */
    public function nuevoAction(Request $request)
    {
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->setFechaRegistro(new \DateTime());
        $nuevoUsuario->setAdministrador(false);
        $nuevoUsuario->setModerador(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevoUsuario);

        return $this->formAction($request, $nuevoUsuario);
    }

    /**
     * @Route("/usuario/form/{id}", name="usuario_form", requirements={"id"="\d+"}, methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function formAction(Request $request, Usuario $usuario)
    {
        $form = $this->createForm(UsuarioType::class, $usuario, [
            'nuevo' => $usuario->getId() === null
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en el usuario guardados con éxito');
                return $this->redirectToRoute('usuario_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('usuario/form.html.twig', [
            'formulario' => $form->createView(),
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/usuario/eliminar/{id}", name="usuario_eliminar", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function eliminarAction(Request $request, Usuario $usuario)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($usuario);
                $em->flush();
                $this->addFlash('success', 'Usuario eliminado con éxito');
                return $this->redirectToRoute('usuario_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar el usuario. Puede que no se pueda eliminar porque tiene aportes.');
                return $this->redirectToRoute('usuario_form', ['id' => $usuario->getId()]);
            }
        }
        return $this->render('usuario/eliminar.html.twig', [
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/perfil", name="usuario_perfil", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function perfilAction(Request $request)
    {
        $usuario = $this->getUser();
        $form = $this->createForm(MiUsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en el usuario guardados con éxito');
                return $this->redirectToRoute('portada');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('usuario/perfil_form.html.twig', [
            'formulario' => $form->createView(),
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/usuario/clave/{id}", name="usuario_establecer_clave", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_MODERADOR')")
     */
    public function establecerClaveAction(Request $request, UserPasswordEncoderInterface $encoder, Usuario $usuario) {
        $cambioClave = new CambioClave();

        $form = $this->createForm(CambioClaveType::class, $cambioClave, [
            'es_moderador' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $usuario->setClave(
                    $encoder->encodePassword($usuario, $cambioClave->getNuevaClave())
                );
                $em->flush();
                $this->addFlash('success', 'Cambios en la contraseña guardados con éxito');
                return $this->redirectToRoute('usuario_form', ['id' => $usuario->getId()]);
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar la contraseña');
            }
        }
        return $this->render('usuario/establecer_clave_form.html.twig', [
            'formulario' => $form->createView(),
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/perfil/clave", name="usuario_cambiar_clave", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function cambioClaveAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $cambioClave = new CambioClave();

        $form = $this->createForm(CambioClaveType::class, $cambioClave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                /** @var Usuario $user */
                $user = $this->getUser();
                $user->setClave(
                    $encoder->encodePassword($user, $cambioClave->getNuevaClave())
                );
                $em->flush();
                $this->addFlash('success', 'Cambios en la contraseña guardados con éxito');
                return $this->redirectToRoute('usuario_perfil');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar la contraseña');
            }
        }
        return $this->render('usuario/cambio_clave_form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}
