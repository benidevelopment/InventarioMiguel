<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articulo
 *
 * @ORM\Table(name="articulo", indexes={@ORM\Index(name="fk_Articulo_Categoria_idx", columns={"Categoria_idCategoria"})})
 * @ORM\Entity
 */
class Articulo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdArticulo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idarticulo;

    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion", type="string", length=45, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="NumEjemplar", type="string", length=45, nullable=false)
     */
    private $numejemplar = '1';

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Categoria_idCategoria", referencedColumnName="idCategoria")
     * })
     */
    private $categoriacategoria;



    /**
     * Get idarticulo
     *
     * @return integer
     */
    public function getIdarticulo()
    {
        return $this->idarticulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Articulo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set numejemplar
     *
     * @param string $numejemplar
     *
     * @return Articulo
     */
    public function setNumejemplar($numejemplar)
    {
        $this->numejemplar = $numejemplar;

        return $this;
    }

    /**
     * Get numejemplar
     *
     * @return string
     */
    public function getNumejemplar()
    {
        return $this->numejemplar;
    }

    /**
     * Set categoriacategoria
     *
     * @param \AppBundle\Entity\Categoria $categoriacategoria
     *
     * @return Articulo
     */
    public function setCategoriacategoria(\AppBundle\Entity\Categoria $categoriacategoria = null)
    {
        $this->categoriacategoria = $categoriacategoria;

        return $this;
    }

    /**
     * Get categoriacategoria
     *
     * @return \AppBundle\Entity\Categoria
     */
    public function getCategoriacategoria()
    {
        return $this->categoriacategoria;
    }
    public function __toString() {
        
         $descripcion = $this->descripcion;
         return (string) $descripcion ;
       }
       
}
