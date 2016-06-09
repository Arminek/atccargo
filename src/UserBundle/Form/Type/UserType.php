<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('username', TextType::class, array(
        'attr' => array(
          'placeholder' => 'Login',
        ),
        'label' => false,
      ))
      ->add('plainPassword', RepeatedType::class, array(
          'type' => PasswordType::class,
          'first_options'  => array(
            'attr' => array(
              'placeholder' => 'Hasło'
            ),
            'label' => false,
          ),
          'second_options' => array(
            'attr' => array(
              'placeholder' => 'Powtórz hasło'
            ),
            'label' => false,
          ),
      ))
      ->add('email', EmailType::class, array(
        'attr'  => array(
          'placeholder' => 'Email',
        ),
        'label' => false,
      ));

  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'UserBundle\Entity\User',
    ));
  }
}