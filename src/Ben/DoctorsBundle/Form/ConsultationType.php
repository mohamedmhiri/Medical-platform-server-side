<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ben\DoctorsBundle\Entity\Consultation;
use Symfony\Component\Form\Extension\Core\Type\FormType;


class ConsultationType extends AbstractType
{
    public function __construct()
    {
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', 'text', array('label'=>'Specialité medicale'))
            ->add('motiftype','text',array('label'=>'Motif de consultation'))
            ->add('anamnese', 'textarea',  array('label'=>'Interrogatoire','required'  => false))
//            ->add('person')
            ->add('diagnosis', 'textarea', array('label'=>'Diagnostique','required' => false,))
            ->add('decision', 'textarea', array('label'=>'Conduite tenue','required' => false,))
            ->add('treatment', 'textarea', array('label'=>'Traitement préscrit', 'required'  => false))

        ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Consultation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_consultation';
    }
}
