<?php

namespace Sofia\GenFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sofia\GenFormBundle\Repository\ReponseRepository")
 */
class Reponse
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
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Sofia\GenFormBundle\Entity\Form")
     * @ORM\JoinColumn(name="idF", referencedColumnName="id")
     */
    protected $idF;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateCreation;
    /**
     * @ORM\OneToMany(targetEntity="Sofia\GenFormBundle\Entity\Notification",mappedBy="rep")
     */
    protected $notifs;
    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getIdF()
    {
        return $this->idF;
    }

    /**
     * @param mixed $idF
     */
    public function setIdF($idF): void
    {
        $this->idF = $idF;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifs()
    {
        return $this->notifs;
    }

    /**
     * @param mixed $notifs
     */
    public function setNotifs($notifs): void
    {
        $this->notifs = $notifs;
    }

}
