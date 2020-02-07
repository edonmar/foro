<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=75, minMessage="El nombre debe tener un mínimo de 2 caracteres", maxMessage="El nombre debe tener un máximo de 75 caracteres")
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=30, minMessage="La clave debe tener un mínimo de 8 caracteres", maxMessage="La clave debe tener un máximo de 30 caracteres")
     * @var string
     */
    private $clave;

    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $fechaRegistro;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $administrador;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $moderador;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tema", mappedBy="usuario")
     * @var Tema[]
     */
    private $temas;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Respuesta", mappedBy="usuario")
     * @var Respuesta[]
     */
    private $respuestas;

    /**
     * Usuario constructor.
     */
    public function __construct()
    {
        $this->temas = new ArrayCollection();
        $this->respuestas = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param string $clave
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * @param \DateTime $fechaRegistro
     * @return Usuario
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdministrador()
    {
        return $this->administrador;
    }

    /**
     * @param bool $administrador
     * @return Usuario
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;
        return $this;
    }

    /**
     * @return bool
     */
    public function isModerador()
    {
        return $this->moderador;
    }

    /**
     * @param bool $moderador
     * @return Usuario
     */
    public function setModerador($moderador)
    {
        $this->moderador = $moderador;
        return $this;
    }

    /**
     * @return Tema[]
     */
    public function getTemas()
    {
        return $this->temas;
    }

    /**
     * @param Tema[] $temas
     * @return Usuario
     */
    public function setTemas($temas)
    {
        $this->temas = $temas;
        return $this;
    }

    /**
     * @return Respuesta[]
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }

    /**
     * @param Respuesta[] $respuestas
     * @return Usuario
     */
    public function setRespuestas($respuestas)
    {
        $this->respuestas = $respuestas;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = ['ROLE_USER'];

        if ($this->isAdministrador())
            $roles[] = 'ROLE_ADMINISTRADOR';
        else
            if ($this->isModerador())
                $roles[] = 'ROLE_MODERADOR';

        return $roles;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->getClave();
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getNombre();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }
}
