<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario
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
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
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
}
