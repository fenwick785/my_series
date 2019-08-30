<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'max' => 60,
                        'minMessage' => 'Minimum 3 caractères',
                        'maxMessage' => 'Maximum 60 caractères',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ !',
                    ]),
                ]
            ])



            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ !',
                    ]),
                    new Assert\Regex([
                        'pattern'=>"/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/",
                        'message'=>'Veuillez renseigner une adresse e-mail valide!',
                    ])
            ]
            ])



            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ !',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'minimum 2 caractères',
                    ]),
                ]
            ])



            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ !',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'minimum 2 caractères',
                    ]),
                ]
            ])



            ->add('kind', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Homme' => 'm',
                    'Femme' => 'f',
                    'Non Binaire' => 't',
                ]
            ])



            ->add('location', CountryType::class,[
                'preferred_choices' => array('FR','US','IT','ES','JP')])



            ->add('birthDate', BirthdayType::class, [
                'label' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'],
                
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ !',
                    ]),
                    new Assert\Regex([
                        'pattern'=>"/^(?=S{8,})(?=S*[a-z])(?=S*[A-Z])(?=S*[d])(?=S*[W])S*$/",
                        'message'=>'Veuillez renseigner au moins 8 caractéres avec au moins un chiffre, une majuscule , une minuscule, et un caractère special'
                    ])
                ]
            ])

            ->add('newsletter', CheckboxType::class,[
                'label' => 'Voulez-vous vous abonnez à la newsletter ?'
            ])


            ->add('submit', SubmitType::class);


        if ($options['admin'] == true) {
            $builder->add('role', ChoiceType::class, [
                'choices' => [
                    'client' => 'ROLE_USER',
                    'contributeur' => 'ROLE_CONTRIBUTOR',
                    'admin' => 'ROLE_ADMIN',
                ]
            ]);
        } else {
            if ($options['user'] == false) {
                $builder
                    ->add('password', RepeatedType::class, [
                        'type' => PasswordType::class,
                        'invalid_message' => 'Les passwords doivent être identiques',
                        'options' => ['attr' => ['class' => 'password-field']],
                        'required' => true,
                        'first_options' => ['label' => 'Mot de passe'],
                        'second_options' => ['label' => 'Confirmer Mot de passe'],
                        'constraints' => [
                                new Assert\NotBlank([
                                    'message' => 'Veuillez renseigner ce champ !']),

                        ]
                ])
                    ->add('cgu', CheckboxType::class,[
                        'label' => false,
                        'mapped'=>false,
                        'constraints' => new IsTrue(array('message' => "Veuillez accepter les Conditions Générales d'Utilisation pour valider votre inscription"))
                    ]);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
           
            'admin' => false,
            'user' => false,
        ]);
    }
}
