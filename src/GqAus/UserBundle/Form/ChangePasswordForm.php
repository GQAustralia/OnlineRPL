<?php

namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordForm extends AbstractType
{

    /**
     * Function to get name
     */
    public function getName()
    {
        return 'password';
    }

    /**
     * Function to build change password form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldpassword', 'password', array('required' => false));
        $builder->add('newpassword', 'password', array('required' => false));
        $builder->add('confirmnewpassword', 'password', array('required' => false));
        $builder->add('save', 'submit');
    }

}
