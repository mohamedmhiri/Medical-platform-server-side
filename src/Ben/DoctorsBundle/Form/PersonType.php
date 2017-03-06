<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin')
            ->add('firstname')
            ->add('familyname')
            ->add('email','text',array('required' => false,))
            ->add('birthday', 'date', array('widget' => 'single_text'))
            ->add('birthcity','text',array('required' => false,))
            ->add('gender', 'choice', array('choices' => array('Féminin' => 'Féminin','Masculin' => 'Masculin'),
                    'required' => false,))
            ->add('contry', 'text',array('required' => false,))
            ->add('city', 'text',array('required' => false,))
            ->add('address')
            ->add('gsm', 'text',array('required' => false,))
            ->add('parentGsm', 'text',array('label'=>'GSM2','required' => false,))
            ->add('cnsstype', 'choice', array('choices' => array('Cnam' => 'Cnam','Cnrps' => 'Cnrps','Cnss' => 'Cnss','Assurance privée' => 'Assurance privée','sans' => 'sans', 'autre'=>'autre')))
            ->add('cnssnum', 'text',array('required' => false,))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Person'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_person';
    }
}
