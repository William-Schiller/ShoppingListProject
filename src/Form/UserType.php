<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('roles')
           // ->add('password')
            ->add('picture', FileType::class, [
                'label' => 'Image de profil',
                'mapped' => false,//pas associe a une entite
                'required' => false,
                'constraints' => [
                    new Image([ //new Image
                        'maxSize' => '10240k',
                        ])
                ],
//                'constraints' => [
//                    new File([ //new Image
//                        'maxSize' => '10240k',
//                        'mimeTypes' => [
//                            'image/*',
//                        ],
//                        'mimeTypesMessage' => 'Please upload a valid document',
//                    ])
//                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
