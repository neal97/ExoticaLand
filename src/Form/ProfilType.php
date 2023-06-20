<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Email :",
                

                // 'row_attr' => [
                //     'class' => 'form-floating',
                // ],
                // "required" => false,
                'disabled' => true, // Champ en lecture seule
                'attr' => [
                    'readonly' => true,

                    // tableau des attributs 
                    // "class" => "border border-dark row mb-3 d-flex justify-content-center",
                    'class' => 'form-control-readonly', // Ajoute la classe "form-control-readonly"
                ],
               
            ])
            ->add('nom', TextType::class, [
                "label" => "Nom :",
                "required" => false,
                
                'disabled' => true,

                
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                "attr" => [ // tableau des attributs 
                    "class" => "border border-dark row mb-3 d-flex justify-content-center",
                    

                ]
            ])
            ->add('prenom', TextType::class, [
                "label" => "Prénom :",
                "required" => false,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'disabled' => true,
                "attr" => [ // tableau des attributs 
                    "class" => "border border-dark row mb-3 d-flex justify-content-center"

                ]
            ])
            ->add('adresse', TextType::class, [
                "label" => "Adresse :",
                "required" => false,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                "attr" => [ // tableau des attributs 
                    "class" => "border border-dark row mb-3 d-flex justify-content-center"

                ]
            ])
            ->add('cp', IntegerType::class, [
                "label" => "Code postal :",
                "required" => false,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                "attr" => [ // tableau des attributs 
                    "class" => "border border-dark row mb-3 d-flex justify-content-center"

                ]
            ])
            ->add('tel', IntegerType::class, [
                "label" => "Téléphone :",
                "required" => false,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                "attr" => [ // tableau des attributs 
                    "class" => "border border-dark row mb-3 d-flex justify-content-center"

                ]
            ])

            // ->add('password', PasswordType::class, [
            //     "label" => "Password :",
            //     "required" => false,
            //     'row_attr' => [
            //         'class' => 'form-floating',
            //     ],
            //     "attr" => [ // tableau des attributs 
            //         "class" => "border border-dark row mb-3 d-flex justify-content-center"

            //     ]
                
            // ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'first_options'  => ['label' => 'Mot de passe : '],
                'second_options' => ['label' => 'Confirmer le mot de passe : '],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                "class" => "border border-dark row mb-3"
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


            ->add('Validez', SubmitType::class, [
                "attr" => [ // tableau des attributs 
                    "class" => "btn btn-dark d-flex justify-content-center"

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

