<?php

namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class IdFilesForm extends AbstractType
{

    /**
     * Function to build Id files form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'entity', array(
            'class' => 'GqAusUserBundle:DocumentType',
            'property' => 'typeWithPoints',
            'empty_value' => 'Select Document Type',
            'required' => false
        ));
        $builder->add('browse', 'file', array('required' => false,'attr' => array('class' => 'hidden uploadFile')));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-red', 'label' => 'Submit'),
        ));
    }

    /**
     * Function to get name
     */
    public function getName()
    {
        return 'userfiles';
    }

}
