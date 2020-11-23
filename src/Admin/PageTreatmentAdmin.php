<?php

declare(strict_types=1);

namespace App\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;

class PageTreatmentAdmin extends AbstractAdmin
{
    protected function configureBatchActions($actions)
    {
        if (isset($actions['delete'])) {
            unset($actions['delete']);
        }

        return $actions;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title')
            ->add('text', CKEditorType::class)
            ->add('picture', ModelListType::class, ['required' => true], ['link_parameters' => ['context' => 'static_pages']])
            ->add('sort');
    }
}
