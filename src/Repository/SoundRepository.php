<?php

namespace App\Repository;

use App\Entity\Sound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sound>
 */
class SoundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sound::class);
    }

    // src/Repository/SoundRepository.php
    // Ajouter cette méthode dans la classe existante

    public function findByFilters(?int $categoryId, ?int $styleId): array
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.category', 'c')
            ->leftJoin('s.style', 'st')
            ->addSelect('c', 'st'); // optimisation : évite les requêtes N+1

        if ($categoryId) {
            $qb->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

        if ($styleId) {
            $qb->andWhere('st.id = :styleId')
                ->setParameter('styleId', $styleId);
        }

        return $qb->getQuery()->getResult();
    }
}
