<?php

namespace AppBundle\Security;

use AppBundle\Entity\Usuario;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TemaVoter extends Voter
{

    const TEMA_EDITAR = 'TEMA_EDITAR';

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
            self::TEMA_EDITAR
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

        // Atributos que NO dependen de $subject
        switch ($attribute) {
            case self::TEMA_EDITAR:
                // Mostrar el menú si se cumple alguna de estas condiciones:
                // 1. El usuario tiene el rol de ROLE_MODERADOR
                if ($this->accessDecisionManager->decide($token, ['ROLE_MODERADOR'])) {
                    return true;
                }

                return false;
        }

        return false;
    }
}