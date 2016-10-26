<?php

namespace SiteBlogBundle\Repository;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{

    public function getAdvertWithCategories(array $categoryNames)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->join('a.categories', 'c')->addSelect('c');
        $qb->where($qb->expr()->in('c.name', $categoryNames));

        return $qb->getQuery()->getResult();
    }


}
