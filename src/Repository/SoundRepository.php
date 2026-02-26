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

    public function findByFilters(
        ?int $categoryId,
        ?int $styleId,
        ?int $priceMin,
        ?int $priceMax,
        string $sort = 'name',
        string $order = 'ASC'
    ): array {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.category', 'c')
            ->leftJoin('s.style', 'st')
            ->addSelect('c', 'st');

        if ($categoryId) {
            $qb->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

        if ($styleId) {
            $qb->andWhere('st.id = :styleId')
                ->setParameter('styleId', $styleId);
        }

        if ($priceMin !== null) {
            $qb->andWhere('s.price >= :priceMin')
                ->setParameter('priceMin', $priceMin);
        }

        if ($priceMax !== null) {
            $qb->andWhere('s.price <= :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        // Sécurisation du tri : on n'accepte que des valeurs connues
        $allowedSorts = ['name' => 's.name', 'price' => 's.price'];
        $allowedOrders = ['ASC', 'DESC'];

        $sortField = $allowedSorts[$sort] ?? 's.name';
        $sortOrder = in_array($order, $allowedOrders) ? $order : 'ASC';

        $qb->orderBy($sortField, $sortOrder);

        return $qb->getQuery()->getResult();
    }
}
