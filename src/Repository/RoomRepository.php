<?php

namespace App\Repository;

use App\Entity\Room;
use App\Model\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Room>
 *
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

// Définition de la classe RoomRepository qui étend ServiceEntityRepository
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }
    // Méthode pour trouver des salles en fonction des critères de recherche
    public function findBySearch(SearchData $search): array // Méthode findBySearch 
{
    $query = $this // 
        ->createQueryBuilder('r');      // Crée une requête sur l'entité Room

    if (!empty($search->q)) {  // Si le champ de recherche n'est pas vide
        $query = $query
            ->andWhere('r.title LIKE :q') // Ajoute une condition sur le titre
            ->setParameter('q', "%{$search->q}%"); // Définit le paramètre de la requête
    }

    return $query->getQuery()->getResult();
}
    //    /**
    //     * @return Room[] Returns an array of Room objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Room
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
