<?php

namespace App\Form;

use App\Entity\AccessibilityConsultingRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessibilityConsultingRequestType extends AbstractType
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
            ->add('webSiteUrl', UrlType::class, [
                'label' => 'URL du site (optionnel)',
                'required' => false,
            ])
            ->add('appName', TextType::class, [
                'label' => 'Nom de l’application (optionnel)',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccessibilityConsultingRequest::class,
        ]);
    }
}
