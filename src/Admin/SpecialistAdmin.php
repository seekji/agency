<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class SpecialistAdmin extends AbstractAdmin
{
    protected function configureBatchActions($actions)
    {
        if (isset($actions['delete'])) {
            unset($actions['delete']);
        }

        return $actions;
    }

    protected function configureListFields(ListMapper $list)
    {
        unset($this->listModes['mosaic']);

        $list
            ->add('id')
            ->add('name')
            ->add('position')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Специалист')
                ->with('Свойства', ['class' => 'col-md-12'])
                    ->add('name')
                    ->add('position')
                    ->add('quote')
                    ->add('picture', ModelListType::class, ['required' => true], ['link_parameters' => ['context' => 'specialists']])
                    ->add('sort')
                ->end()
            ->end()
        ;
    }
}