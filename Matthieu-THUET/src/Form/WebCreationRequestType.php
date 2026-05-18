<?php

namespace App\Form;

use App\Entity\WebCreationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebCreationRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Entreprise',
                'required' => false,
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'E-mail',
            ])
            ->add('projectTitle', TextType::class, [
                'label' => 'Titre du projet',
            ])
            ->add('shortProjectDescription', TextareaType::class, [
                'label' => 'Description du projet',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WebCreationRequest::class,
        ]);
    }
}
