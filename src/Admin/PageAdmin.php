<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Locale\LocaleInterface;
use App\Entity\Page;
use App\Form\Admin\Page\AchievementsType;
use App\Form\Admin\Page\HistoryType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Regex;

class PageAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('clone', $this->getRouterIdParameter() . '/clone');
    }

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
            ->add('title')
            ->add('isPublished')
            ->add('locale', null, [], ChoiceType::class, [
                'choices' => array_flip(LocaleInterface::LOCALE_LIST)
            ]);
    }

    protected function configureListFields(ListMapper $list)
    {
        unset($this->listModes['mosaic']);

        $list
            ->add('id')
            ->add('title')
            ->add('locale', 'choice', ['choices' => LocaleInterface::LOCALE_LIST])
            ->add('isPublished')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'clone' => [
                        'template' => 'admin/CRUD/list__action_clone.html.twig',
                    ],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Основные свойства')
                ->with('Страница', ['class' => 'col-md-9'])
                    ->add('title');

        if ($this->isCurrentRoute('edit', 'app.admin.page')) {
            $form->add('slug');
        }

        $form
                    // text
                    ->add('description', CKEditorType::class)
                    // about
                    ->add('excerpt')
                    ->add('specialists', ModelType::class, ['multiple' => true, 'by_reference' => false])
                    ->add('achievements', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'entry_type' => AchievementsType::class,
                    ])
                    ->add('history',  \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'entry_type' => HistoryType::class,
                    ])
                    ->add('treatments', \Sonata\Form\Type\CollectionType::class, [
                        'type' => AdminType::class,
                        'by_reference' => false,
                    ], [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ])
                    // contacts
                    ->add('coordinates', null, [
                        'help' => 'Формат: `широта;долгота`, например: <strong>39.1,39.2</strong>',
                        'constraints' => [
                            new Regex("/^([-]?)([\d]+)((((\.)(\d+))?(,)))(([-]?)([\d]+)((\.)(\d+))?)$/")
                        ]
                    ])
                ->end()
                ->with('Состояние', ['class' => 'col-md-3'])
                    ->add('isPublished')
                    ->add('locale', ChoiceType::class, [
                        'choices' => array_flip(LocaleInterface::LOCALE_LIST)
                    ])
                    ->add('type', ChoiceFieldMaskType::class, [
                        'choices' => array_flip(Page::TYPE_LIST),
                        'map' => [
                            Page::TYPE_TEXT => ['description'],
                            Page::TYPE_ABOUT => ['excerpt', 'specialists', 'history', 'achievements', 'treatments'],
                            Page::TYPE_CONTACTS => ['coordinates'],
                        ],
                        'required' => true
                    ])
                ->end()
            ->end()
        ;
    }
}
