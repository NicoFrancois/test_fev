<?php

use App\Command\Command\AddUserCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, [
            'required'=> true,
            'label'=> 'First Name',
        ]);

        $builder->add('lastName', TextType::class, [
            'required'=> true,
            'label'=> 'Last Name',
        ]);

        $builder->add('birthDate', DateType::class, [
            'label' => 'Birth Date',
            'required' => true,
            'widget' => 'single_text',
            'html5' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AddUserCommand::class,
        ]);
    }

}