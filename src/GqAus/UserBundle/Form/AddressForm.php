<?php
namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressForm extends AbstractType
{
    public function getName()
    {
        return 'useraddress';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('address', 'text');
        $builder->add('area', 'text', array('required' => false));
        $builder->add('city', 'text', array('required' => false));
        $builder->add('state', 'text', array('required' => false));
        $builder->add('pincode', 'text', array('required' => false));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\GqAus\UserBundle\Entity\UserAddress',
        ));
    }    
}
