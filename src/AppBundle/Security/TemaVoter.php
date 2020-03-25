<?php

namespace AppBundle\Security;

use AppBundle\Entity\Tema;
use AppBundle\Entity\Usuario;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TemaVoter extends Voter
{

    const TEMA_EDITAR = 'TEMA_EDITAR';
    const TEMA_CREAR_RESPUESTA = 'TEMA_CREAR_RESPUESTA';

    private $accessDecisionManager;

    /**
     * TemaVoter constructor.
     */
    public function __construct(AccessDecisionManagerInterface $accessDecisionManager)
    {
        $this->accessDecisionManager = $accessDecisionManager;
    }


    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if (in_array($attribute, [
            self::TEMA_EDITAR,
            self::TEMA_CREAR_RESPUESTA
        ], true)) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $usuario = $token->getUser();

        if (!$usuario instanceof Usuario) {
            return false;
        }

        // Atributos que SÍ dependen de $subject

        // Comprobar si $subject es un Tema
        if (!$subject instanceof Tema) {
            return false;
        }

        switch ($attribute) {
            case self::TEMA_EDITAR:
                // Se puede editar el tema $subject si se cumple alguna de estas condiciones:
                // 1. El usuario tiene el rol de ROLE_ADMINISTRADOR
                if ($this->accessDecisionManager->decide($token, ['ROLE_ADMINISTRADOR'])) {
                    return true;
                }

                // 2. El usuario tiene el rol de ROLE_MODERADOR y el creador del tema NO tiene el rol de ROLE_ADMINISTRADOR
                if ($this->accessDecisionManager->decide($token, ['ROLE_MODERADOR']) && !$subject->getUsuario()->isAdministrador()) {
                    return true;
                }

                // 3. El usuario es el creador del tema, el tema no está cerrado y el tema ha sido creado hace 30 minutos o menos
                if($subject->getUsuario() == $usuario) {
                    if($subject->isCerrado() == false) {
                        $fechaActual = new \DateTime();
                        $diff = date_diff($subject->getFechaCreacion(), $fechaActual);
                        $minutos = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
                        if($minutos <= 30) {
                            return true;
                        }
                    }
                }

                return false;

            case self::TEMA_CREAR_RESPUESTA:
                // Se puede crear una respuesta en el tema si se cumple alguna de estas condiciones:
                // 1. El usuario tiene el rol de ROLE_MODERADOR
                if ($this->accessDecisionManager->decide($token, ['ROLE_MODERADOR'])) {
                    return true;
                }

                // 2. El tema no está cerrado
                if($subject->isCerrado() == false) {
                    return true;
                }

                return false;
        }

        return false;
    }
}