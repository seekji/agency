<?php

declare(strict_types=1);

namespace App\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TechnologyBlockAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('groupName')
            ->add('title')
            ->add('picture', ModelListType::class, ['required' => true, 'help' => 'Детальная картинка'], ['link_parameters' => ['context' => 'technologies']])
            ->add('text', CKEditorType::class)
            ->add('sort', HiddenType::class)
        ;
    }
}
