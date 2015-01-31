<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ComposeMessageForm extends AbstractType
{
    public function getName()
    {
        return 'compose';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('to', 'email');
        $builder->add('subject', 'text');
        $builder->add('message', 'textarea');
        $builder->add('discard', 'reset');
        $builder->add('save', 'submit');
    }
}
