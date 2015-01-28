<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EvidenceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array(
            'label' => 'Photo', 'multiple' => 'multiple'
        ));
        $builder->add('hid_unit', 'hidden');
        $builder->add('hid_course', 'hidden');
        $builder->add('self_assessment', 'textarea', array('required' => false));
        $builder->add('save', 'submit', array(
            'label' => 'Upload',
        ));
    }

    public function getName()
    {
        return 'file';
    }
}