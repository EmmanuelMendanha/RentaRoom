<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '📆 All bookings')
            ->setEntityLabelInSingular('Booking')
            ->setEntityLabelInPlural('Bookings')
            ->setSearchFields(['name'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
{
    return [
        IdField::new('id')->hideOnForm(),
        AssociationField::new('user'),

        ChoiceField::new('status')
            ->setChoices([
                'En attente' => 'pending',
                'Validé' => 'validated',
            ])
            ->allowMultipleChoices(false)
            ->onlyOnForms(),
        TextField::new('formattedStatus', 'Status')
            ->formatValue(function ($value) {
                if 
                    ($value === null) {
                    return 'En attente';
                }

                 if ($value === '1') {
                    return 'Validé';
                }
                    if  ($value === '0') {
                        return 'Refusé';
                    }
                
                

                return $value;
                
            })
            ->onlyOnIndex(),
        
    ];
}
}
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */



