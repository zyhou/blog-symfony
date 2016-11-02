<?php

namespace SiteBlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
             ->add('date',      'date')
             ->add('title',     'text')
             ->add('author',    'text')
             ->add('content',   'textarea')
             ->add('published', 'checkbox', array('required' => false))
             ->add('image',      new ImageType())
             ->add('categories', 'entity', array(
                 'class'    => 'SiteBlogBundle:Category',
                 'property' => 'name',
                 'multiple' => true
             ))
             ->add('save',      'submit')
         ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBlogBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'siteblogbundle_advert';
    }


}
