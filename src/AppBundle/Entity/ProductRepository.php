<?php

namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;
/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByName($productName)
    {
        if(empty($productName))
        {
            $result = '';
        }
        else
        {
            $query = $this->getEntityManager()
                ->createQuery(
                    'SELECT p FROM AppBundle:Product p WHERE p.name LIKE :productName'
                )
                ->setParameter('productName','%'.$productName.'%');

            $result = $query->getResult();
        }

        return $result;
    }

}