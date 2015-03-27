<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MatrixForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('browse', 'file', array('required' => false));
        $builder->add('type', 'hidden', array(
            'data' => 'matrix'
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-red', 'label' => 'Upload'),
        ));
    }

    public function getName()
    {
        return 'matrix';
    }

}