<?php

namespace Sofia\GenFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Sofia\GenFormBundle\Repository\TraceRepository")
 */
class Trace
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Sofia\GenFormBundle\Entity\Form")
     * @ORM\JoinColumn(name="idF", referencedColumnName="id")
     */
    private $idF;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mailD;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateS;

    public function getId(): ?int
    {
        return $this->id;
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



    public function getMailD(): ?string
    {
        return $this->mailD;
    }

    public function setMailD(string $mailD): self
    {
        $this->mailD = $mailD;

        return $this;
    }

    public function getDateS(): ?string
    {
        return $this->dateS;
    }

    public function setDateS(string $dateS): self
    {
        $this->dateS = $dateS;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

}
