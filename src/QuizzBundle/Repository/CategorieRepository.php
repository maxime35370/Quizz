<?php

namespace QuizzBundle\Repository;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository
{
    public function listeCategorie()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT c FROM QuizzBundle:Categorie c');
        return $query->getResult();
    }

    public function listeCategorieDuTest($idTest)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT c FROM QuizzBundle:Categorie c JOIN c.tests t WHERE t.id =:idTest');
        $query->setParameter('idTest',$idTest);
        return $query->getResult();
    }

    public function getCategorieSuivante($idCategorie,$idTest)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT c FROM QuizzBundle:Categorie c JOIN c.tests t WHERE t.id = :idTest AND c.id > :idCategorie');
        $query->setParameter('idCategorie', $idCategorie);
        $query->setParameter('idTest', $idTest);
        $query->setMaxResults(1);
        return $query->getResult();
    }

    public function PremiereCategorieDuTest($idTest)
    {
        $em =$this->getEntityManager();
        $query = $em->createQuery('SELECT c FROM QuizzBundle:Categorie c LEFT JOIN c.tests t WHERE t.id = :idTest ORDER BY c.id' );
        $query->setParameter('idTest',$idTest);
        $query->setMaxResults(1);
        return $query->getResult();
    }

    public function DerniereCategorieDuTest($idTest)
    {
        $em =$this->getEntityManager();
        $query = $em->createQuery('SELECT c FROM QuizzBundle:Categorie c LEFT JOIN c.tests t WHERE t.id = :idTest ORDER BY c.id DESC' );
        $query->setParameter('idTest',$idTest);
        $query->setMaxResults(1);
        return $query->getResult();
    }

    public function NbCategorieDuTest($idTest)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT COUNT (c) FROM QuizzBundle:Categorie c JOIN c.tests t WHERE t.id =:idTest');
        $query->setParameter('idTest',$idTest);
        return $query->getSingleScalarResult();
    }
}

