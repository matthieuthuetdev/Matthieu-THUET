<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
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
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
            ])
            ->add('Content', TextareaType::class, [
                'label' => 'Message',
            ])
            ->add('RGPD', CheckboxType::class, [
                'label' => "J'accepte la politique de confidentialité (RGPD)",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
