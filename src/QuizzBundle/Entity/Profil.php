<?php

namespace QuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity(repositoryClass="QuizzBundle\Repository\ProfilRepository")
 */
class Profil
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var bool
     *
     * @ORM\Column(name="estMasculin", type="boolean")
     */
    private $estMasculin;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;
    /**
     * @var text
     *
     * @ORM\Column(name="texte",type="text", nullable=false)
     */
    private $texte;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Profil
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set estMasculin
     *
     * @param boolean $estMasculin
     *
     * @return Profil
     */
    public function setEstMasculin($estMasculin)
    {
        $this->estMasculin = $estMasculin;

        return $this;
    }

    /**
     * Get estMasculin
     *
     * @return bool
     */
    public function getEstMasculin()
    {
        return $this->estMasculin;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Profil
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get texte
     *
     * @return text
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set texte
     *
     * @param text $texte
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
    }


}

