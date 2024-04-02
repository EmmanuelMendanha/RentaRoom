<?php

namespace App\Form;

use App\Model\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Construction du formulaire    
        $builder
            ->add('q', TextType::class, [
                'attr' => [
                    'placeholder' => 'Recherche via un mot clé...'  // Placeholder pour le champ de recherche
                ],
                'empty_data' => '',     // Valeur par défaut du champ de recherche 
                'required' => false
            ]);
    }
    // Configuration des options du formulaire
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET', // Méthode GET pour l'envoi du formulaire
            'csrf_protection' => false // Désactivation de la protection CSRF
        ]);
    }
}