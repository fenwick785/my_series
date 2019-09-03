<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('nbSeason', IntegerType::class, [
                'required' => false,
                'empty_data' => "",
            ])
            ->add('nbEpisode',IntegerType::class, [
                'required' => false,
                'empty_data' => "",
            ])
            ->add('startDate', IntegerType::class, [
                'required' => false,
                'empty_data' => "",
            ])
            ->add('public', ChoiceType::class, [
                'choices'=>[
                    'Tout public'=>'TP',
                    '-10'=>'-10',
                    '-12'=>'-12',
                    '-16'=>'-16',
                    '-18'=>'-18',
                ],
                'required' => false,
                'empty_data' => "",
            ])
            ->add('status', ChoiceType::class,[
                'choices'=>[
                    'TERMINE'=>'Ended',
                    'EN COURS'=>'Continuing',
                    'A VENIR'=>'coming',
                ]
            ])
            ->add('synopsis', TextType::class, [
                'required' => false,
                'empty_data' => "",
            ])
            ->add('photo', FileType::class, [
                'required' => false,
                'empty_data' => "",
                'data_class' => null,
            ])
            ->add('duration', IntegerType::class)
            ->add('nationality', CountryType::class,[
                'preferred_choices' => array('FR','US','IT','ES','JP')])
            ->add('categories')
            ->add('actors')
            ->add('Ajouter Serie', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
