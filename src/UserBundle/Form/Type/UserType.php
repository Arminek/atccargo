<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
      ))
      ->add('avatar', ChoiceType::class, array(
        'choices' => array(
          'Avatar 1' => 1,
          'Avatar 2' => 2,
          'Avatar 3' => 3,
          'Avatar 4' => 4,
          'Avatar 5' => 5,
          'Avatar 6' => 6,
          'Avatar 7' => 7,
          'Avatar 8' => 8,
          'Avatar 9' => 9,
        ),
        'expanded' => true,
        'label'    => false,
      ));

  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'UserBundle\Entity\User',
    ));
  }
}