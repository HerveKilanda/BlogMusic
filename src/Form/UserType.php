<?php

namespace App\Form;

use Assert\Length;
use App\Entity\User;
use Assert\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options,): void
    {
        $builder
            ->add('email')

            ->add('plainPassword', TextType::class,[
                'mapped' => false,
                
            ])
            ->add('pseudo')
            ->add('isVerified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function validator(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('plainPassword', new NotBlank());
        $metadata->addPropertyConstraint('plainPassword', new Assert\Length([
            'min' => 5,
            
            'max' => 50,
            'minMessage' => 'Your first name must be at least {{ limit }} characters long',
            'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
        ]));

    }
}
