<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\CaseBlock;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CaseBlockAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('type', ChoiceFieldMaskType::class, [
                'choices' => array_flip(CaseBlock::TYPES_LIST),
                'map' => [
                    CaseBlock::TYPE_TEXT => ['text'],
                    CaseBlock::TYPE_MEDIA => ['media'],
                ],
                'required' => true
            ])
            ->add('media', ModelListType::class)
            ->add('text', CKEditorType::class)
            ->add('sort', HiddenType::class)
        ;
    }
}