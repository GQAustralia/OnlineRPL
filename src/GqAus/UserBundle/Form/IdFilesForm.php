<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class IdFilesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'entity', array(
            'class' => 'GqAusUserBundle:DocumentType',
            'property' => 'type',
            'empty_value' => 'Select Document Type'
        ));
        $builder->add('browse', 'file');
        $builder->add('save', 'submit', array(
    'attr' => array('class' => 'btn btn-red', 'label' => 'Submit'),
));
    }
    
    public function getName()
    {
        return 'userfiles';
    }
}