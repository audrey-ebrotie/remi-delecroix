<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Photo>
 *
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    public function save(Photo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Photo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
 * @return Photo[] Returns an array of Photo objects
 */
    public function findByCategory(string $categoryName)
    {
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c') // Assurez-vous que 'category' est la relation correcte dans votre entité Photo
            ->where('c.name = :categoryName')
            ->setParameter('categoryName', $categoryName)
            ->orderBy('p.created_at', 'DESC') // Assurez-vous que 'created_at' est le champ correct pour le tri
            ->getQuery()
            ->getResult();
    }
}
