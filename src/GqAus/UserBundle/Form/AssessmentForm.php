<?php
namespace GqAus\UserBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AssessmentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('hid_unit_assess', 'hidden');
        $builder->add('hid_course_assess', 'hidden');
        $builder->add('self_assessment', 'textarea');
        $builder->add('save', 'submit', array(
            'label' => 'Save',
        ));
    }
    public function getName()
    {
        return 'assessmentfile';
    }
}