<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ReferenceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('browse', 'file', array('required' => false));
        $builder->add('type', 'hidden', array(
            'data' => 'reference'
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-red', 'label' => 'Upload'),
        ));
    }

    public function getName()
    {
        return 'reference';
    }

}