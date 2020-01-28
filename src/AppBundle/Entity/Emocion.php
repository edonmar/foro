<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="emocion")
 */
class Emocion
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
     * @Assert\Length(min=2, max=20, minMessage="El nombre debe tener un mínimo de 2 caracteres", maxMessage="El nombre debe tener un máximo de 20 caracteres")
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=50, minMessage="El icono debe tener un mínimo de 1 carácter", maxMessage="El icono debe tener un máximo de 20 caracteres")
     * @var string
     */
    private $icono;

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
     * @return Emocion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcono()
    {
        return $this->icono;
    }

    /**
     * @param string $icono
     * @return Emocion
     */
    public function setIcono($icono)
    {
        $this->icono = $icono;
        return $this;
    }
}
