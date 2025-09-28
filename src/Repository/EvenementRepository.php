<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function searchEvents(?string $titre, ?string $type): array
{
    $queryBuilder = $this->createQueryBuilder('e'); // Changer 'repository' par 'this'
    if ($titre) {
        $queryBuilder->andWhere('e.titre LIKE :titre')
            ->setParameter('titre', '%' . $titre . '%'); // Ajouter '%' pour la recherche par LIKE
    }
    if ($type) {
        $queryBuilder->andWhere('e.type = :type')
            ->setParameter('type', $type);
    }
    

    return $queryBuilder->getQuery()->getResult();//génère une requête SQL grâce à getQuery() et l'exécute avec getResult()
}

}
