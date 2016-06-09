<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckCodeType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('email', EmailType::class, array(
        'attr'  => array(
          'placeholder' => 'Email'
        ),
        'label' => false,
      ))
      ->add('activationCode', TextType::class, array(
        'attr' => array(
          'placeholder' => 'Kod aktywacyjny'
        ),
        'label' => false,
      ))
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'UserBundle\Entity\ActivationCode',
      'validation_groups' => false,
    ));
  }
}