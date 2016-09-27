<?php

namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use GqAus\UserBundle\Form\AddressForm;

class ProfileForm extends AbstractType
{

    /**
     * Function to get name
     */
    public function getName()
    {
        return 'userprofile';
    }

    /**
     * Function to build profile form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('firstname', 'text', array('required' => false));
        $builder->add('lastname', 'text', array('required' => false));
        $builder->add('email', 'text', array('required' => false));
        $builder->add('gender', 'choice', array('choices' => array('male' => 'Male', 'female' => 'Female'), 'multiple' => false,
            'expanded' => true, 'required' => true));
        $builder->add('phone', 'integer', array('required' => false));
        $builder->add('ceoname', 'text', array('required' => false));
        $builder->add('ceoemail', 'text', array('required' => false));
        $builder->add('ceophone', 'text', array('required' => false));
        //$builder->add('dateOfBirth', 'text', array('required' => false));
        $builder->add('universalStudentIdentifier', 'text', array('required' => false));
        $builder->add('contactname', 'text', array('required' => false));
        $builder->add('contactemail', 'text', array('required' => false));
        $builder->add('contactphone', 'text', array('required' => false));
        $builder->add('userImage', 'file', array('required' => false, 'data_class' => null));
        $builder->add('address', new AddressForm(), array('label' => false));
        //$builder->add('crmId', 'text', array('required' => false));
        $builder->add('save', 'submit',array('label' => 'UPDATE','attr' =>array('class' => 'btn update_btn disable','disabled' => 'disabled')));
    }

}
