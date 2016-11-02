<?php

namespace SiteBlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
                 'multiple' => true,
                 'expanded' => false
             ))
             ->add('save',      'submit')
         ;

        // On ajoute une fonction qui va écouter l'évènement PRE_SET_DATA
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                $advert = $event->getData();

                if (null === $advert) {
                    return;
                }

                if (!$advert->getPublished() || null === $advert->getId()) {
                    $event->getForm()->add('published', 'checkbox', array('required' => false));
                } else {
                    $event->getForm()->remove('published');
                }
            }
        );
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
