<?php

namespace App\Form;

use App\Entity\Serie;
use App\Entity\Season;
use Webmozart\Assert\Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'empty_data' => "",
            ])
            ->add('orderSeason', IntegerType::class)
            ->add('synopsis', TextType::class,[
                'required' => false,
                'empty_data' => "",
            ])
            ->add('photo', FileType::class, [
                'required' => false,
                'empty_data' => "",
            ])
            ->add('totalEpisodes', IntegerType::class, [
                'required' => false,
                'empty_data' => "",
            ])
            ->add('year', IntegerType::class, [
                'required' => false,
                'empty_data' => "",
            ])
            ->add('idSerie')
            ->add('translatedLanguages')
            ->add('Ajouter Saison', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
