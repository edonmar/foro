<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="respuesta")
 */
class Respuesta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="text")
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
    private $editada;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="respuestas")
     * @var Usuario
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tema", inversedBy="respuestas")
     * @var Tema
     */
    private $tema;

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
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param string $texto
     * @return Respuesta
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
     * @return Respuesta
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEditada()
    {
        return $this->editada;
    }

    /**
     * @param bool $editada
     * @return Respuesta
     */
    public function setEditada($editada)
    {
        $this->editada = $editada;
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
     * @return Respuesta
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return Tema
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * @param Tema $tema
     * @return Respuesta
     */
    public function setTema($tema)
    {
        $this->tema = $tema;
        return $this;
    }
}
