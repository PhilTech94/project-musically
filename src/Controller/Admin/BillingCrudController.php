<?php

namespace App\Controller\Admin;

use App\Entity\Billing;
use App\Enum\BillingStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BillingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Billing::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Facture')
            ->setEntityLabelInPlural('Factures')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des factures');
    }

    public function configureFields(string $pageName): iterable
    {
        $statusForm = ChoiceField::new('status', 'Statut')
            ->onlyOnForms()
            ->setChoices([
                'Brouillon' => BillingStatus::DRAFT,
                'Devis envoyé' => BillingStatus::QUOTE,
                'En attente' => BillingStatus::PENDING,
                'Paiement accepté' => BillingStatus::ACCEPTED,
                'Paiement refusé' => BillingStatus::REFUSED,
                'Annulé' => BillingStatus::CANCELLED,
                'Remboursé' => BillingStatus::REFUNDED,
            ]);

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
            TextField::new('phone', 'Téléphone'),
            TextField::new('email', 'Email'),
            TextField::new('statusLabel', 'Statut')->onlyOnIndex(),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            IntegerField::new('price', 'Prix'),
            $statusForm,
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
        ];
    }
}
