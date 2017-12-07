<?php

namespace Form;


use Models\UsersModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                'firstname',
                TextType::class,
                [
                    'constraints' =>
                        [
                            new Assert\NotBlank()
                        ]
                ]
        )
            ->add(
                'lastname',
                TextType::class,
                [
                    'constraints' =>
                        [
                            new Assert\NotBlank()
                        ]
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'constraints' =>
                        [
                            new Assert\NotBlank(),
                            new Assert\Regex(['pattern' => '/^[A-Za-z0-9_-]*$/']),
                            new Assert\Length(['min' => 2])
                        ]
                ]
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'required' => true,                             // Default true
                    'first_options' =>
                        [
                          'label' => 'Password'
                        ],
                    'second_options' =>
                        [
                            'label' => 'Repeat password'
                        ],
                    'constraints' =>
                        [
                            new Assert\NotBlank()
                        ]
                ]
            );

        if($options['standalone']){
            $builder->add('submit', SubmitType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', UsersModel::class);
        $resolver->setDefault('standalone', false);
        $resolver->addAllowedTypes('standalone', 'bool');
    }

}