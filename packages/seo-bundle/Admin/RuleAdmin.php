<?php

namespace Seo\SeoBundle\Admin;

use Doctrine\Common\Cache\ClearableCache;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Seo\SeoBundle\Form\Type\ExtraDataType;
use Seo\SeoBundle\Form\Type\MetaTagType;
use Seo\SeoBundle\Form\Type\UrlPatternType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RuleAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'priority',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('pattern')
            ->add('title')
            ->add('priority');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('pattern')
            ->addIdentifier('title')
            ->addIdentifier('priority');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('General')
            ->with('Основные настройки правила')
            ->add('pattern', UrlPatternType::class, ['sonata_help' => $this->getPatternHelp()])
            ->add('title', TextType::class, ['required' => false, 'sonata_help' => 'Заголовок сайта, отображается в тегах &lt;title&gt;&lt;/title&gt;'])
            ->add('entity', TextType::class, ['sonata_help' => 'Необходимо указать для динамических свойств.', 'required' => false])
            ->add('locale', TextType::class, ['sonata_help' => 'Принимает два значения: en|ru.'])
            ->add('priority', TextType::class, ['sonata_help' => 'Приоритет правила. Если url соответстует нескольким правилам, то применяется правило с наибольшим приоритетом'])
            ->end()
            ->end()
            ->tab('Meta-Tags')
            ->with('Мета теги', ['description' => 'Для тегов должен быть указан name или(и) property. В content разрешно использование переменных. Список доступных переменных и условий отличается для страниц - необходимо уточнять у разработчиков.'])
            ->add('meta_tags', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => MetaTagType::class,
                'required' => false,
                'label' => false,
                'prototype_name' => 'meta_tag',
                'by_reference' => false,
            ])
            ->end()
            ->end()
            ->tab('Extra')
            ->with('Дополнительные данные', ['description' => 'Любые дополнительные данные. Например - заголовки. Использование данных их этого списка должно быть реализовано разработчиками. В значениях разрешно использование переменных. Список доступных переменных и условий отличается для страниц - необходимо уточнять у разработчиков.'])
            ->add('extra', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => ExtraDataType::class,
                'required' => false,
                'label' => false,
                'prototype_name' => 'extra_field',
                'by_reference' => false,
            ])
            ->end()
            ->end();
    }

    /**
     * @return string
     *
     * TODO: get description from syntax handlers
     */
    private function getPatternHelp()
    {
        return $this->trans('form_pattern_description', [], 'SeoBundle');
    }

    /**
     * @param mixed $object
     *
     * @return mixed|void
     */
    public function postUpdate($object)
    {
        $this->clearCache();
    }

    /**
     * @param mixed $object
     *
     * @return mixed|void
     */
    public function postPersist($object)
    {
        $this->clearCache();
    }

    /**
     * @param mixed $object
     *
     * @return mixed|void
     */
    public function postRemove($object)
    {
        $this->clearCache();
    }

    /**
     * Clear metadata cache.
     */
    private function clearCache()
    {
        $container = $this->getConfigurationPool()->getContainer();

        if ($container->has('seo.metadata_cache')) {
            $cache = $container->get('seo.metadata_cache');

            if ($cache instanceof ClearableCache) {
                $cache->deleteAll();
            }
        }
    }
}
