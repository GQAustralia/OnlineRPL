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
        $builder->add('area', 'text');
        $builder->add('city', 'text');
        $builder->add('state', 'text');
        $builder->add('pincode', 'text');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\GqAus\UserBundle\Entity\UserAddress',
        ));
    }    

}
