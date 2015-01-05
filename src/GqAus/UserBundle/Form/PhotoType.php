<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('photo', 'file', array(
            'label' => 'Photo',
        ));
         $builder->add('save', 'submit', array(
            'label' => 'Upload',
        ));
    }

    public function getName()
    {
        return 'photo';
    }
}