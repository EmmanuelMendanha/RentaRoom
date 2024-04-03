<?php

namespace App\Controller\Admin;

use App\Entity\Software;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SoftwareCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Software::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '📆 All softwares')
            ->setEntityLabelInSingular('Software')
            ->setEntityLabelInPlural('Softwares')
            ->setSearchFields(['name'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

  
    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         TextField::new('name')
    //         ->setLabel('Name')
    //         ->setHelp('The name of the software'),
    //     ];
    // }
   
}
