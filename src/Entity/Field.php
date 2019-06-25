<?php
/**
 * Created by PhpStorm.
 * User: safa
 * Date: 12/04/2019
 * Time: 12:31 PM
 */

namespace Sofia\GenFormBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sofia\GenFormBundle\Repository\FieldRepository")
 */
class Field
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true,name="Label")
     */
    private $Label;
    /**
     * @ORM\Column(type="string", length=255, nullable=true,name="obligation")
     */
    private $obligation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true,name="itemArray")
     */
    private $itemArray;

    /**
     * @ORM\ManyToOne(targetEntity="Sofia\GenFormBundle\Entity\Form")
     * @ORM\JoinColumn(name="idForm", referencedColumnName="id")
     */
    private $idForm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypee(): ?string
    {
        return $this->typee;
    }

    public function setTypee(?string $typee): self
    {
        $this->typee = $typee;

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

    /**
     * @return mixed
     */
    public function getIdForm()
    {
        return $this->idForm;
    }

    /**
     * @param mixed $idForm
     */
    public function setIdForm($idForm): void
    {
        $this->idForm = $idForm;
    }

    /**
     * @return mixed
     */
    public function getObligation()
    {
        return $this->obligation;
    }

    /**
     * @param mixed $obligation
     */
    public function setObligation($obligation): void
    {
        $this->obligation = $obligation;
    }



}