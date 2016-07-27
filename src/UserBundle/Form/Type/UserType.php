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
          'invalid_message' => 'user.plainPassword.not.match',
          'first_options'  => array(
            'attr' => array(
              'placeholder' => 'Password'
            ),
            'label' => false,
          ),
          'second_options' => array(
            'attr' => array(
              'placeholder' => 'Repeat password'
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
          'Avatar1' => 0,
          'Avatar2' => 1,
          'Avatar3' => 2,
          'Avatar4' => 3,
          'Avatar5' => 4,
          'Avatar6' => 5,
          'Avatar7' => 6,
          'Avatar8' => 7,
          'Avatar9' => 8,
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