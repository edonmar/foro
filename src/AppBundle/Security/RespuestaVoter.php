<?php

namespace AppBundle\Security;

use AppBundle\Entity\Respuesta;
use AppBundle\Entity\Usuario;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RespuestaVoter extends Voter
{

    const RESPUESTA_EDITAR = 'RESPUESTA_EDITAR';

    private $accessDecisionManager;

    /**
     * RespuestaVoter constructor.
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
            self::RESPUESTA_EDITAR
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

        // Comprobar si $subject es una Respuesta
        if (!$subject instanceof Respuesta) {
            return false;
        }

        switch ($attribute) {
            case self::RESPUESTA_EDITAR:
                // Se puede editar la respuesta $subject si se cumple alguna de estas condiciones:
                // 1. El usuario tiene el rol de ROLE_ADMINISTRADOR
                if ($this->accessDecisionManager->decide($token, ['ROLE_ADMINISTRADOR'])) {
                    return true;
                }

                // 2. El usuario tiene el rol de ROLE_MODERADOR y el creador de la respuesta NO tiene el rol de ROLE_ADMINISTRADOR
                if ($this->accessDecisionManager->decide($token, ['ROLE_MODERADOR']) && !$subject->getUsuario()->isAdministrador()) {
                    return true;
                }

                // 3. El usuario es el creador de la respuesta, el tema no está cerrado y la respuesta ha sido creada hace 30 minutos o menos
                if($subject->getUsuario() == $usuario) {
                    if($subject->getTema()->isCerrado() == false) {
                        $fechaActual = new \DateTime();
                        $diff = date_diff($subject->getFechaCreacion(), $fechaActual);
                        $minutos = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
                        if($minutos <= 30) {
                            return true;
                        }
                    }
                }

                return false;
        }

        return false;
    }
}