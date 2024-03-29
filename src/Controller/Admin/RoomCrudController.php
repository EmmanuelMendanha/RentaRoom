<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use Doctrine\DBAL\Types\DecimalType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class RoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Room::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '📆 All rooms')
            ->setEntityLabelInSingular('Room')
            ->setEntityLabelInPlural('Rooms')
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
            TextField::new('title')
            ->setLabel('Name')
            ->setHelp('The name of the room'),
            TextField::new('description')
            ->setLabel('Description')
            ->setHelp('The description of the room'),
            IntegerField::new('surface')
            ->setLabel('Surface')
            ->setHelp('The surface of the room'),
            IntegerField::new('capacity')
            ->setLabel('Capacity')
            ->setHelp('The capacity of the room'),
            TextField::new('address')
            ->setLabel('Address')
            ->setHelp('The address of the room'),
            MoneyField::new('price')->setCurrency('EUR')
            ->setLabel('Price')
            ->setHelp('The price of the room'),
            AssociationField::new('ergonomics')
            ->setLabel('Ergonomy')
            ->setHelp('The ergonomy of the room'),
            AssociationField::new('equipments')
            ->setLabel('Equipment')
            ->setHelp('The equipment of the room'),
        ];
    }
}
