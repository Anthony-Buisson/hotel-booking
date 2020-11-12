<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserType extends AbstractType
{
    private $encoder;

    /**
     * UserType constructor.
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $encoder = $this->encoder;
        $builder
            ->add('email')
            ->add('password')
            ->add('roles', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'mapped' => false,
                'expanded' => true,
                'multiple' => true
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) use($encoder){
            $user = $event->getData();
            $form = $event->getForm();
            if($user) {
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            }
        })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
