<?php

namespace Workshop5Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TelephoneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('telephoneNumber')->add('type')
                ->add('save', 'submit', array('label' => 'Dodaj nr telefonu'))
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'Domowy' => 'domowy',
                        'Służbowy' => 'sluzbowy',
                        'Inny' => 'inny',
                    )
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Workshop5Bundle\Entity\Telephone'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'workshop5bundle_telephone';
    }


}
