<?php

namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ComposeMessageForm extends AbstractType
{

    /**
     * Function to get name
     */
    public function getName()
    {
        return 'compose';
    }

    /**
     * Function to build message compose form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('toUserName', 'text');
        $builder->add('to', 'hidden');
        $builder->add('subject', 'text');
        $builder->add('message', 'textarea', array('required' => false));
        $builder->add('unitId', 'hidden');
        $builder->add('save', 'submit');
    }

}
