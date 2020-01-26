<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Respuesta;
use AppBundle\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RespuestaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('texto', TextareaType::class, [
                'label' => 'Texto'
            ])
            ->add('usuario', EntityType::class, [
                'class' => Usuario::class,
                'label' => 'Escrita por'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Respuesta::class
        ]);
    }

}