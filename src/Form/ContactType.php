<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 
use Symfony\Component\Form\Extension\Core\Type\EmailType; 

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
           
           
            -> add('subject', TextType::class,[
                'label' => 'Objet'
            ])
            -> add('message', TextareaType::class,[
                'label' => 'Message'
            ])
            -> add('submit', SubmitType::class, array(
				'label' => 'Envoyer'
            ));

            if ($options['user'] != NULL){
                $builder    
                    -> add('firstName', TextType::class, [
                        'label' => 'Prénom',
                        'attr' => array(
                            'value' => $options['user'] -> getFirstName()
                        )
                    ])
                    -> add('lastName', TextType::class,[
                        'label' => 'Nom',
                        'attr' => array(
                        'value' => $options['user'] -> getLastName()
                    )
                    ])
                    -> add('email', EmailType::class,[
                    'label' => 'E-mail',
                    'attr' => array(
                        'value' => $options['user'] -> getEmail()
                    )
                ]);
             }
             else{
                $builder 
                    -> add('email', EmailType::class,[
                        'label' => 'email'
                    ])
                    -> add('lastName', TextType::class,[
                        'label' => 'Nom'
                    ])
                    -> add('firstName', TextType::class,[
                        'label' => 'Prénom'
                 ]);
             }
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => null,
           
        ]);
    }
}
