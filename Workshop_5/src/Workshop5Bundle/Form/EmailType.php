<?php

namespace Workshop5Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('emailAddress') 
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'Domowy' => 'domowy',
                        'Służbowy' => 'sluzbowy',
                        'Inny' => 'inny',
                    )
                ))
                ->add('save', 'submit', array('label' => 'Dodaj email'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Workshop5Bundle\Entity\Email'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'workshop5bundle_email';
    }


}
