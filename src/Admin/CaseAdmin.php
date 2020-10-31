<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Locale\LocaleInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
                    ->add('locale', ChoiceType::class, [
                        'choices' => array_flip(LocaleInterface::LOCALE_LIST)
                    ])
                    ->add('title');

        if ($this->isCurrentRoute('edit', 'app.admin.case')) {
            $form->add('slug');
        }

        $form
                ->add('excerpt')
                ->add('services')
                ->add('branch', ModelType::class, [])
                ->add('previewPicture', ModelListType::class, ['required' => true], ['link_parameters' => ['context' => 'cases']])
            ->end()
            ->with('Состояние', ['class' => 'col-md-3'])
//                ->add('isActive')
//                ->add('isCanceled')
            ->end();
    }


}