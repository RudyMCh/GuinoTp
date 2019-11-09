<?php

namespace App\Form;

use App\Entity\Doc;
use App\Entity\User;
use App\Entity\Lobby;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;




class DocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class)
            ->add('createdAt')
            ->add('user', EntityType::class,[
                'class' => User::class,
                'choice_label' => 'lastname'
            ])
            ->add('lobby', EntityType::class,[
                'class' => Lobby::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Doc::class,
        ]);
    }
}
