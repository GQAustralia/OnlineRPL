<?php

namespace GqAus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NotesForm extends AbstractType
{

    /**
     * Function to build notes form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('note_unit_id', 'hidden');
        $builder->add('unit_notes', 'textarea', array("required" => false));
        $builder->add('unit_note_type', 'hidden');
        $builder->add('unit_save', 'submit', array(
            'label' => 'Add Notes',
        ));
        $builder->add('unit_cancel', 'button', array(
            'label' => 'Cancel',
        ));
    }

    /**
     * Function to get name
     */
    public function getName()
    {
        return 'addnotes';
    }

}
