<?php

namespace TransportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TransportType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('startCity', HiddenType::class)
      ->add('endCity', HiddenType::class)
      ->add('cargo', HiddenType::class)
      ->add('distance', IntegerType::class, array(
        'attr' => array(
          'placeholder' => 'Amount',
        )
      ))
      ->add('weight', IntegerType::class, array(
        'attr' => array(
          'placeholder' => 'Weight',
        )
      ))
      ->add('damage', IntegerType::class, array(
        'attr' => array(
          'placeholder' => 'Amount',
        )
      ))
      ->add('burnedFuel', IntegerType::class, array(
        'attr' => array(
          'placeholder' => 'Amount',
        )
      ))
      ->add('fueled', IntegerType::class, array(
        'attr' => array(
          'placeholder' => 'Amount',
        )
      ))
      ->add('country', HiddenType::class)
      ->add('screenshot', FileType::class)
      ->add('startDate', DateTimeType::class, array(
        'attr' => array(
          'placeholder' => '2016-03-11 8:45',
        ),
        'widget' => 'single_text',
      ))
      ->add('endDate', DateTimeType::class, array(
        'attr' => array(
          'placeholder' => '2016-03-12 23:12',
        ),
        'widget' => 'single_text',
      ))
      ->add('reportTransport', SubmitType::class, array(
        'block_name' => 'reportTransport',
        'label' => 'Send a request'
      ))
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'TransportBundle\Entity\Transport',
    ));
  }
}