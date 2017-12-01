<?php

namespace QuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultat
 *
 * @ORM\Table(name="resultat")
 * @ORM\Entity(repositoryClass="QuizzBundle\Repository\ResultatRepository")
 */
class Resultat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_Resultat", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idResultat;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Test")
     */
    private $idTest;

    /**
     * @var int
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DatePassage", type="date")
     */
    private $datePassage;


    /**
     * Get id
     *
     * @return int
     */
    public function getIdResultat()
    {
        return $this->idResultat;
    }

    /**
     * Set idTest
     *
     * @param integer $idTest
     *
     * @return Resultat
     */
    public function setIdTest($idTest)
    {
        $this->idTest = $idTest;

        return $this;
    }

    /**
     * Get idTest
     *
     * @return int
     */
    public function getIdTest()
    {
        return $this->idTest;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Resultat
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set datePassage
     *
     * @param \DateTime $datePassage
     *
     * @return Resultat
     */
    public function setDatePassage($datePassage)
    {
        $this->datePassage = $datePassage;

        return $this;
    }

    /**
     * Get datePassage
     *
     * @return \DateTime
     */
    public function getDatePassage()
    {
        return $this->datePassage;
    }
}

