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
 * @ORM\Entity(repositoryClass="Sofia\GenFormBundle\Repository\FormRepository")
 */
class Form
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
    private $title;


    /**
     * @ORM\Column(type="integer")
     */
    private $view;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Sofia\GenFormBundle\Entity\Field",mappedBy="idForm",cascade={"remove"})
     */
    protected $fields;
    /**
     * @ORM\OneToMany(targetEntity="Sofia\GenFormBundle\Entity\Trace",mappedBy="idF",cascade={"remove"})
     */
    protected $tarces;

    /**
     * @ORM\OneToMany(targetEntity="Sofia\GenFormBundle\Entity\Reponse",mappedBy="idF",cascade={"remove"})
     */
    protected $responses;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateCreation;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateExpiration;


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
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * @param mixed $dateExpiration
     */
    public function setDateExpiration($dateExpiration): void
    {
        $this->dateExpiration = $dateExpiration;
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     */
    public function setFields($fields): void
    {
        $this->fields = $fields;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return mixed
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param mixed $responses
     */
    public function setResponses($responses): void
    {
        $this->responses = $responses;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param mixed $view
     */
    public function setView($view): void
    {
        $this->view = $view;
    }

    /**
     * @return mixed
     */
    public function getTarces()
    {
        return $this->tarces;
    }

    /**
     * @param mixed $tarces
     */
    public function setTarces($tarces): void
    {
        $this->tarces = $tarces;
    }


}
