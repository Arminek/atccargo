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
          'Avatar1' => 1,
          'Avatar2' => 2,
          'Avatar3' => 3,
          'Avatar4' => 4,
          'Avatar5' => 5,
          'Avatar6' => 6,
          'Avatar7' => 7,
          'Avatar8' => 8,
          'Avatar9' => 9,
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