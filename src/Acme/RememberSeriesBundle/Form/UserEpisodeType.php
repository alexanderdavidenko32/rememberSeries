<?php

namespace Acme\RememberSeriesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserEpisodeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('watched')
            ->add('progress', 'time', array(
                'with_seconds' => true,
                'label' => false
            ))
//            ->add('userId')
        // TODO: make entity field as hidden, display: none is temporary
            ->add('episodeId', 'entity', array(
                'class' => 'Acme\RememberSeriesBundle\Entity\Episode',
                'property' => 'id',
                'attr'=> array('style'=>'display:none'),
                'label' => false
            ))
        ;
    }

    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\RememberSeriesBundle\Entity\UserEpisode'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_rememberseriesbundle_userepisode';
    }
}
