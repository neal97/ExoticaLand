<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe doivent correspondre',
            'first_options'  => ['label' => 'Mot de passe : '],
            'second_options' => ['label' => 'Confirmer le mot de passe : '],
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password',
            "class" => "border border-dark row mb-3 "
        ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit contenir min. 6 caractères.',
                    // max length allowed by Symfony for security reasons
                    'max' => 20,
                    'maxMessage' => 'Votre mot de passe doit contenir max. 20 caractères.',
                ]),
            ],
        ])
            ->add('Enregistrer', SubmitType::class,[
                "attr" => [
                     "class" => "btn btn-lg m-2 ",
                 "placeholder" => "votre numero de telephone"
            ]  
             ]
        );
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
