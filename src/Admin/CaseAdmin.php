<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Cases;
use App\Entity\Locale\LocaleInterface;
use App\Form\Admin\CaseAchievementType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ->add('locale', null, [], ChoiceType::class, [
                'choices' => array_flip(LocaleInterface::LOCALE_LIST)
            ])
            ->add('title');
    }

    protected function configureListFields(ListMapper $list)
    {
        unset($this->listModes['mosaic']);

        $list
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('locale', 'choice', ['choices' => LocaleInterface::LOCALE_LIST])
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

        if ($this->isCurrentRoute('edit', 'app.admin.case')) {
            $form->add('slug');
        }

        $form
                ->add('excerpt')
                ->add('similarCase')
                ->add('services', ModelType::class, ['multiple' => true, 'by_reference' => false])
                ->add('branch', ModelType::class, [])
                ->add('previewPicture', ModelListType::class, ['required' => true], ['link_parameters' => ['context' => 'cases']])
            ->end()
            ->with('Состояние', ['class' => 'col-md-3'])
                ->add('locale', ChoiceType::class, [
                    'choices' => array_flip(LocaleInterface::LOCALE_LIST)
                ])
                ->add('sort')
                ->add('isActive')
                ->add('isItemBig')
                ->add('isShowOnHomepage')
//                ->add('isCanceled')
            ->end()
        ->end()
        ->tab('Детальный слайд')
            ->with('Слайд')
                ->add('slideTitle')
                ->add('detailMedia', ModelListType::class, ['required' => true])
            ->end()
        ->end()
        ->tab('Клиент')
            ->with('Клиент')
                ->add('client', ModelListType::class)
            ->end()
        ->end()
        ->tab('Итоги')
            ->with('Итоги')
                ->add('resultType', ChoiceFieldMaskType::class, [
                    'choices' => array_flip(Cases::RESULTS_LIST),
                    'map' => [
                        Cases::RESULT_OFFER => ['offer'],
                        Cases::RESULT_ACHIEVEMENT => ['achievements'],
                    ],
                    'required' => true
                ])
                ->add('offer', CKEditorType::class)
                ->add('achievements', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'entry_type' => CaseAchievementType::class,
                ])
            ->end()
        ->end()
        ->tab('Задача и решение')
            ->with('Задача', ['class' => 'col-md-6'])
                ->add('taskTitle')
            ->end()
            ->with('Решение', ['class' => 'col-md-6'])
                ->add('blocks', \Sonata\Form\Type\CollectionType::class, [
                    'type' => AdminType::class,
                    'by_reference' => false,
                ], [
                    'edit' => 'inline',
                    'inline' => 'standard',
                    'sortable' => 'position',
                ])
            ->end()
        ->end()
        ->tab('Специалист')
            ->with('Специалист')
                ->add('specialist', ModelListType::class, ['required' => false])
            ->end()
        ->end()
        ->tab('Остальное')
            ->with('Остальное')
                ->add('tools', CKEditorType::class, ['required' => false])
            ->end()
        ->end()
        ;
    }
}
