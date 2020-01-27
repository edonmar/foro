<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Tema;
use AppBundle\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título'
            ])
            ->add('texto', TextareaType::class, [
                'label' => 'Texto'
            ])
            ->add('fijado', CheckboxType::class, [
                'label' => '¿Tema fijado?',
                'required' => false
            ])
            ->add('cerrado', CheckboxType::class, [
                'label' => '¿Tema cerrado?',
                'required' => false
            ])
            ->add('usuario', EntityType::class, [
                'class' => Usuario::class,
                'label' => 'Escrito por'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tema::class
        ]);
    }

}