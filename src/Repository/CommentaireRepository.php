<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 *
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    //    /**
    //     * @return Commentaire[] Returns an array of Commentaire objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

        public function findOneBySomeField($produit, $commentaire,$id): ?Commentaire
       {
           return $this->createQueryBuilder('c')
           ->join('c.produit','produit')
                ->Where('c.produit = :id')
                ->setParameter('id', $id)

                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
      /*  public function fetchSale($sid){
            $query = $this->createQueryBuilder('c')
                ->where('c.id = :id')
                ->setParameter('id', $sid)
                ->getQuery()
                ->getOneOrNullResult();
        }*/
}
