<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CaseAdmin extends AbstractAdmin
{

    protected function configureBatchActions($actions)
    {
        if (isset($actions['delete'])) {
            unset($actions['delete']);
        }

        return $actions;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('title');
    }

    protected function configureListFields(ListMapper $list)
    {
        unset($this->listModes['mosaic']);

        $list
            ->add('id')
            ->add('title')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Основные свойства')
            ->with('Основные свойства', ['class' => 'col-md-9'])
            ->add('title');

//        if ($this->isCurrentRoute('edit', 'app.admin.event')) {
//            $form->add('slug');
//        }

        $form
            ->add('services')
            ->add('branch', ModelType::class, [])
            ->end()
            ->with('Состояние', ['class' => 'col-md-3'])
//                ->add('isActive')
//                ->add('isCanceled')
            ->end();
    }


}