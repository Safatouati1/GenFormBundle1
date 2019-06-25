<?php

namespace Sofia\GenFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sofia\GenFormBundle\Repository\CategorieFieldRepository")
 */
class CategorieField
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $itemArray;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $obligation;
    /**
     * @ORM\ManyToOne(targetEntity="Sofia\GenFormBundle\Entity\Categorie")
     * @ORM\JoinColumn(name="idC", referencedColumnName="id")
     */
    private $idC;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->Label;
    }

    public function setLabel(?string $Label): self
    {
        $this->Label = $Label;

        return $this;
    }

    public function getItemArray(): ?string
    {
        return $this->itemArray;
    }

    public function setItemArray(?string $itemArray): self
    {
        $this->itemArray = $itemArray;

        return $this;
    }

    public function getObligation(): ?string
    {
        return $this->obligation;
    }

    public function setObligation(?string $obligation): self
    {
        $this->obligation = $obligation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdC()
    {
        return $this->idC;
    }

    /**
     * @param mixed $idC
     */
    public function setIdC($idC): void
    {
        $this->idC = $idC;
    }

}
