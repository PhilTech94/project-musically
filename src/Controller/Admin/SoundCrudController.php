<?php

namespace App\Controller\Admin;

use App\Entity\Sound;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class SoundCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sound::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Son')
            ->setEntityLabelInPlural('Sons')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des sons')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un son')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un son')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détail du son');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            IntegerField::new('price', 'Prix'),
            DateTimeField::new('createdAt', 'Créé à')->hideOnForm(),
        ];
    }
}
