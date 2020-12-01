<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Locale\LocaleInterface;
use App\Entity\Technology;
use App\Form\Admin\CaseAchievementType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TechnologyAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('delete');
    }

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
            ->add('title')
            ->add('isActive')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Свойства технологии')
                ->with('Технология', ['class' => 'col-md-9'])
                    ->add('title');

        if ($this->isCurrentRoute('edit', 'app.admin.technology')) {
            $form->add('slug');
        }

        $form
                    ->add('excerpt')
                    ->add('media', ModelListType::class, ['required' => true, 'help' => 'Картинка для списка'], ['link_parameters' => ['context' => 'technologies']])
                    ->add('picture',ModelListType::class, ['required' => true, 'help' => 'Детальная картинка'], ['link_parameters' => ['context' => 'technologies']])

                    ->add('AizekText')
                    ->add('AizekAchievementsTitle')
                    ->add('AizekAchievements', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'entry_type' => CaseAchievementType::class,
                    ])
                    ->add('AizekIcons', ModelType::class, ['multiple' => true, 'by_reference' => false])
                    ->add('AizekPictureBlock',ModelListType::class, ['required' => true], ['link_parameters' => ['context' => 'technologies']])
                ->end()
                ->with('Состояние', ['class' => 'col-md-3'])
                    ->add('locale', ChoiceType::class, [
                        'choices' => array_flip(LocaleInterface::LOCALE_LIST)
                    ])
                    ->add('sort')
                    ->add('type', ChoiceFieldMaskType::class, [
                        'choices' => array_flip(Technology::TYPES_LIST),
                        'map' => [
                            Technology::TYPE_DEFAULT => [],
                            Technology::TYPE_AIZEK => ['AizekText', 'AizekAchievementsTitle', 'AizekAchievements', 'AizekPictureBlock', 'AizekIcons'],
                        ],
                        'required' => true
                    ])
                    ->add('isActive')
                ->end()
            ->end()
            ->tab('Блоки с текстом')
                ->with('Блоки', ['class' => 'col-md-12'])
                    ->add('blocks', \Sonata\Form\Type\CollectionType::class, [
                        'type' => AdminType::class,
                        'by_reference' => false,
                    ], [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'sort',
                    ])
                ->end()
            ->end()
        ;
    }
}