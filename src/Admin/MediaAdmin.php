<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Media;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;

class MediaAdmin extends AbstractAdmin
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
            ->add('href')
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
            ->with('Свойства медиа-файла')
                ->add('title')
                ->add('type', ChoiceFieldMaskType::class, [
                    'choices' => array_flip(Media::TYPE_LIST),
                    'map' => [
                        Media::TYPE_PICTURE => ['media'],
                        Media::TYPE_VIDEO => ['media'],
                        Media::TYPE_HREF => ['href', 'media'],
                    ],
                    'required' => true
                ])
                ->add('href', UrlType::class)
                ->add('media', ModelListType::class, ['required' => true], ['link_parameters' => ['context' => 'medias']])
            ->end()
        ;
    }
}
