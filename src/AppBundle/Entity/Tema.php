<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
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
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
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
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
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
     */
    public function setEditado($editado)
    {
        $this->editado = $editado;
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
     */
    public function setFijado($fijado)
    {
        $this->fijado = $fijado;
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
     */
    public function setCerrado($cerrado)
    {
        $this->cerrado = $cerrado;
    }
}
