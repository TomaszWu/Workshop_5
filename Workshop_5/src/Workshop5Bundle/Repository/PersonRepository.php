<?php

namespace Workshop5Bundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonRepository extends EntityRepository
{
    
    public function findAPerson($personToCheck) {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
                'SELECT u FROM Workshop5Bundle:Person u'
                . ' WHERE u.name = :personToCheck '
                )->setParameter('personToCheck', $personToCheck);
        $person = $query->getResult();
        return $person;
    }
}
