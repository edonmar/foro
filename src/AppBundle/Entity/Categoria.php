<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="categoria")
 */
class Categoria
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
     * @Assert\Length(min=2, max=50, minMessage="El nombre debe tener un mínimo de 2 caracteres", maxMessage="El nombre debe tener un máximo de 50 caracteres")
     * @var string
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tema", mappedBy="categoria")
     * @var Tema[]
     */
    private $temas;

    /**
     * Categoria constructor.
     */
    public function __construct()
    {
        $this->temas = new ArrayCollection();
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
     * @return Categoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
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
     * @return Categoria
     */
    public function setTemas($temas)
    {
        $this->temas = $temas;
        return $this;
    }
}
