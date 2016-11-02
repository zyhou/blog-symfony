<?php

namespace SiteBlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvertEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('date');
    }

    public function getName()
    {
        return 'site_blogbundle_advert_edit';
    }

    public function getParent()
    {
        return new AdvertType();
    }
}