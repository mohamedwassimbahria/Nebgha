<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

//    /**
//     * @return Offre[] Returns an array of Offre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offre
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function searchOffres(?string $nom, ?string $type): array
{
    $queryBuilder = $this->createQueryBuilder('e'); // Changer 'repository' par 'this'
    if ($nom) {
        $queryBuilder->andWhere('e.nom LIKE :nom')
            ->setParameter('nom', '%' . $nom . '%'); // Ajouter '%' pour la recherche par LIKE
    }
    if ($type) {
        $queryBuilder->andWhere('e.type = :type')
            ->setParameter('type', $type);
    }

    return $queryBuilder->getQuery()->getResult();
}


}
