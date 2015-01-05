<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use GqAus\UserBundle\Form\AddressForm;

class ProfileForm extends AbstractType
{
    public function getName()
    {
        return 'userprofile';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('firstname', 'text');
        $builder->add('lastname', 'text');
        $builder->add('email', 'text');
        $builder->add('phone', 'text');
        $builder->add('address', new AddressForm(), array( 'label' => false ));
        $builder->add('save', 'submit');

    }
}
