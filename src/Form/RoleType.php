<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'nom ',
                'attr' => array(
                    'placeholder' => 'Nom'
                )
            )
            )
            ->add('prenom', TextType::class, array(
                'label' => 'prenom ',
                'attr' => array(
                    'placeholder' => 'Prenom'
                )
            )
            )
            ->add('email', TextType::class, array(
                'label' => 'email ',
                'attr' => array(
                    'placeholder' => 'Email'
                )
            )
            )
            ->add('adresse', TextType::class, array(
                'label' => 'adresse ',
                'attr' => array(
                    'placeholder' => 'Adresse'
                )
            )
            )
            ->add('image',FileType::class,[
                'mapped' => false
            ])
            ->add('password', PasswordType::class, array(
                'label' => 'password ',
                'attr' => array(
                    'placeholder' => 'Password'
                )
            )
            )
            ->add('type'
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
