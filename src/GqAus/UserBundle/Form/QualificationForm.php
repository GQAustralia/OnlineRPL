<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QualificationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('browse', 'file');
        $builder->add('type', 'hidden', array(
            'data' => 'qualification'
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-red', 'label' => 'Upload'),
        ));
    }

    public function getName()
    {
        return 'qualification';
    }

}