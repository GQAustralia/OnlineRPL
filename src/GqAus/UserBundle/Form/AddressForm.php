<?php

namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressForm extends AbstractType
{

    /**
     * Function to get name
     * return string
     */
    public function getName()
    {
        return 'useraddress';
    }

    /**
     * Function to builf address form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('address', 'text', array('required' => false));
        $builder->add('area', 'text', array('required' => false));
        $builder->add('suburb', 'text', array('required' => false));
        $builder->add('city', 'text', array('required' => false));
        $builder->add('state', 'text', array('required' => false));
        $builder->add('country', 'text', array('required' => false));
        $builder->add('pincode', 'text', array('required' => false));
        $builder->add('postal', 'text', array('required' => false));
    }

    /**
     * Function to set default options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\GqAus\UserBundle\Entity\UserAddress',
        ));
    }

}
