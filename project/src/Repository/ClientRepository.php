<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Client $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Client $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    // les enregistrements dont les clients ont plus de 30 matériels, et dont le matériel vendu est
    // supérieur à 30.000 euros.

    // select c.first_name, c.last_name, SUM(l.quantite) as qt, SUM(m.price) as prix
    // from client c
    // join lien l on c.id = l.client_id
    // join materiel m on m.id = l.materiel_id
    // Group by c.first_name, c.last_name
    // HAVING SUM(l.quantite)> 30 and SUM(m.price) > 3000000
    // order by c.id;



    /**
     * @return Client[] Returns an array of Client objects
    */
    public function findClientWithExpensiveMateriel()
    {
        return $this->createQueryBuilder('c')
            ->select('c as client')
            ->join('c.liens', 'l')
            ->join('l.materiel', 'm')
            ->where('m.price > 3000000')
            ->groupBy('c')
            ->having('SUM(l.quantite) > 30')
            ->orderBy('c.last_name')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Client[] Returns an array of Client objects
    */
    public function findBestClient()
    {
        return $this->createQueryBuilder('c')
            ->select('c as client, SUM(l.quantite) as qt, SUM(m.price * l.quantite) as prix')
            ->join('c.liens', 'l')
            ->join('l.materiel', 'm')
            ->groupBy('c')
            ->orderBy('prix', 'desc')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
