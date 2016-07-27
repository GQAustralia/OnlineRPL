<?php

namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FileForm extends AbstractType
{

    /**
     * Function to build evidence form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array(
            'label' => 'Photo', 'multiple' => 'multiple', 'required' => false
        ));
        $builder->add('save', 'submit', array(
            'label' => 'Upload',
        ));
    }

    /**
     * Function to get name
     */
    public function getName()
    {
        return 'file';
    }

}
