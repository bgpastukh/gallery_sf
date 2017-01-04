<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GalleryRepository extends EntityRepository
{
    public function sortByDate()
    {
        $query = $this->createQueryBuilder('g')
            ->orderBy('g.date', 'ASC')
            ->getQuery();

        $products = $query->getResult();

        return $products;
    }


    public function sortBySize()
    {
        $query = $this->createQueryBuilder('g')
            ->orderBy('g.size', 'ASC')
            ->getQuery();

        $products = $query->getResult();

        return $products;
    }
}