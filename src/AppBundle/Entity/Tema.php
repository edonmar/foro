<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tema")
 */
class Tema
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $titulo;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $texto;

    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $editado;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $fijado;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $cerrado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="temas")
     * @var Usuario
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Respuesta", mappedBy="tema")
     * @var Respuesta[]
     */
    private $respuestas;

    /**
     * Tema constructor.
     */
    public function __construct()
    {
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
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     * @return Tema
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param string $texto
     * @return Tema
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * @param \DateTime $fechaCreacion
     * @return Tema
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEditado()
    {
        return $this->editado;
    }

    /**
     * @param bool $editado
     * @return Tema
     */
    public function setEditado($editado)
    {
        $this->editado = $editado;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFijado()
    {
        return $this->fijado;
    }

    /**
     * @param bool $fijado
     * @return Tema
     */
    public function setFijado($fijado)
    {
        $this->fijado = $fijado;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCerrado()
    {
        return $this->cerrado;
    }

    /**
     * @param bool $cerrado
     * @return Tema
     */
    public function setCerrado($cerrado)
    {
        $this->cerrado = $cerrado;
        return $this;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     * @return Tema
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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
     * @return Tema
     */
    public function setRespuestas($respuestas)
    {
        $this->respuestas = $respuestas;
        return $this;
    }
}
