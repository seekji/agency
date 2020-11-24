<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Locale\LocaleInterface;
use App\Form\Admin\AchievementType;
use App\Form\Admin\MenuLink;
use App\Form\Admin\SocialLink;
use App\Form\Admin\TranslationForm;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class SettingsAdmin extends AbstractAdmin
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

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('locale', null, [], ChoiceType::class, [
                'choices' => array_flip(LocaleInterface::LOCALE_LIST)
            ]);
    }

    protected function configureListFields(ListMapper $list)
    {
        unset($this->listModes['mosaic']);

        $list
            ->add('id')
            ->add('locale', 'choice', ['choices' => LocaleInterface::LOCALE_LIST])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Настройки')
                ->with('Настройки', ['class' => 'col-md-12'])
                    ->add('locale', ChoiceType::class, [
                        'choices' => array_flip(LocaleInterface::LOCALE_LIST),
                        'disabled' => true
                    ])
                    ->add('phone')
                    ->add('address')
                    ->add('email', EmailType::class)
                    ->add('video', ModelType::class)
                ->end()
            ->end()
            ->tab('Политика конфиденциальности')
                ->with('Политика конфиденциальности', ['class' => 'col-md-12'])
                    ->add('privacy', CKEditorType::class, ['required' => false])
                ->end()
            ->end()
            ->tab('Достижения')
                ->with('Достижения', ['class' => 'col-md-12'])
                    ->add('achievements', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'entry_type' => AchievementType::class,
                    ])
                ->end()
            ->end()
            ->tab('Соц. сети')
                ->with('Соц. сети', ['class' => 'col-md-12'])
                    ->add('socialLinks', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'entry_type' => SocialLink::class,
                    ])
                ->end()
            ->end()
            ->tab('Переводы')
                ->with('Переводы', ['class' => 'col-md-12'])
                    ->add('translations', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'entry_type' => TranslationForm::class,
                    ])
                ->end()
            ->end()
            ->tab('Навигация')
                ->with('Ссылки для меню', ['class' => 'col-md-12'])
                    ->add('menuLinks', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'entry_type' => MenuLink::class,
                    ])
                ->end()
            ->end()
        ;
    }

}