<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }


    public function getNextProject($projectId){
        $query = $this->createQueryBuilder('p')
        ->andWhere('p.id > :id')
        ->select('p.slug')
        ->orderBy('p.createdAt', 'ASC')
        ->setMaxResults(1)
        ->setParameter('id', $projectId);

        return $this->getSlug($query->getQuery()->getResult());
    } 

    
    public function getPreviousProject($projectId){
        $query = $this->createQueryBuilder('p')
        ->andWhere('p.id < :id')
        ->select('p.slug')
        ->orderBy('p.createdAt', 'DESC')
        ->setMaxResults(1)
        ->setParameter('id', $projectId);
        
       return $this->getSlug($query->getQuery()->getResult());
    } 

    private function getSlug($result)
    {
        if($result){
            return $result[0]['slug'];
        }
        return null;
    }




    

    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
