<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            "label" => "nom",
            "required" => false,
            "attr" => [
                "class" => "",
                "placeholder" => "votre nom"
            ]
        ])

        ->add('prenom', TextType::class, [
            "label" => "Prenom",
            "required" => false,
            "attr" => [
                "class" => "",
                "placeholder" => "votre Prenom"
            ]
        ])
        ->add('email', EmailType::class)
        ->add('adresse', TextType::class, [
            "label" => "Adresse",
            "required" => false,
            "attr" => [
                "class" => "",
                "placeholder" => "votre adresse"
            ]
        ])
        ->add('cp', IntegerType::class, [
            "label" => "Code Postal",
            "required" => false,
            "attr" => [
                "class" => "",
                "placeholder" => "votre code postal"
            ]
        ])
        ->add('tel', IntegerType::class, [
            "label" => "telephone",
            "required" => false,
            "attr" => [
                "class" => "",
                "placeholder" => "votre numero de telephone"
            ]
        ])
        // ->add('password', RepeatedType::class, [
        //     'type' => PasswordType::class,
        //     'first_options' => ['label' => 'Password'],
        //     'second_options' => ['label' => 'Confirm Password']
        // ])      
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('Enregistrer', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
