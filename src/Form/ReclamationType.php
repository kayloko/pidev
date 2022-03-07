<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref', TextType::class, array(
                'label' => 'ref ',
                'attr' => array(
                    'placeholder' => 'Reference'
                )
            )
            )
            ->add('sujet', TextType::class, array(
                'label' => 'sujet ',
                'attr' => array(
                    'placeholder' => 'Sujet'
                )
            )
            )
            ->add('content', TextareaType::class, array(
                'label' => 'content ',
                'attr' => array(
                    'placeholder' => 'Your Message'
                )
            )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
