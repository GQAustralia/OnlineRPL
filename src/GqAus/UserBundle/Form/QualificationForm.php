<?php

namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QualificationForm extends AbstractType
{

    /**
     * Function to build qualification form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('browse', 'file', array('required' => false));
        $builder->add('type', 'hidden', array(
            'data' => 'qualification'
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-red', 'label' => 'Upload'),
        ));
    }

    /**
     * Function to get name
     */
    public function getName()
    {
        return 'qualification';
    }

}
