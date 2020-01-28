<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Length(max=200, maxMessage="El título debe tener un máximo de 200 caracteres")
     * @var string
     */
    private $titulo;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @var string
     */
    private $texto;

    /**
     * @ORM\Column(type="datetime")
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
     * @Assert\NotNull()
     * @var Usuario
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Respuesta", mappedBy="tema")
     * @var Respuesta[]
     */
    private $respuestas;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categoria", inversedBy="temas")
     * @var Categoria
     */
    private $categoria;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Emocion")
     * @var Emocion[]
     */
    private $emociones;

    /**
     * Tema constructor.
     */
    public function __construct()
    {
        $this->respuestas = new ArrayCollection();
        $this->emociones = new ArrayCollection();
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

    /**
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param Categoria $categoria
     * @return Tema
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * @return Emocion[]
     */
    public function getEmociones()
    {
        return $this->emociones;
    }

    /**
     * @param Emocion[] $emociones
     * @return Tema
     */
    public function setEmociones($emociones)
    {
        $this->emociones = $emociones;
        return $this;
    }
}
