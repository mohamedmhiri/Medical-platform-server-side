<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Collections\ArrayCollection;

class TestType extends AbstractType
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
                ->add('consultation')
                ->add('typeexam', 'text', array('label'=>'Type de l examen'))
                ->add('lieu', 'text', array('label'=>'Lieu'))
                ->add('conclusion', 'textarea', array('label'=>'conclusion','required'  => false))
                //->add('images' , new \Doctrine\Common\Collections\ArrayCollection())
                ->add('date', 'date', array('widget' => 'single_text','label'=>'Date'))
                // ->add('hasvisualissue', 'checkbox', array('label'=>'Trouble visuel','required'  => false))
                // ->add('fixedvisualissue', 'choice', array('choices' => ['Corrigé'=>'Corrigé', 'Non corrigé'=>'Non corrigé'],
                //         'expanded' => true,
                //         'multiple' => false,
                //         'label' => false,
                //         ))


                ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Test'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_test';
    }
}
