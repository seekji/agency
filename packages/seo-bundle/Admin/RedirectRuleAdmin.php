<?php

namespace Seo\SeoBundle\Admin;

use Doctrine\Common\Cache\ClearableCache;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Seo\SeoBundle\Form\Type\UrlPatternType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RedirectRuleAdmin extends AbstractAdmin
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
            ->add('sourceTemplate')
            ->add('destination')
            ->add('code')
            ->add('priority')
            ->add('stopped');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('sourceTemplate')
            ->add('destination')
            ->addIdentifier('code')
            ->addIdentifier('priority')
            ->add('stopped');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sourceTemplate', UrlPatternType::class, ['sonata_help' => $this->getPatternHelp()])
            ->add('destination', TextType::class, ['required' => false, 'sonata_help' => $this->trans('form_destination_description', [], 'SeoBundle')])
            ->add('code', ChoiceType::class, ['choices' => [
                '302' => '302 Found',
                '301' => '301 Moved Permanently',
                '201' => '201 Created',
                '303' => '303 See Other',
                '307' => '307 Temporary Redirect',
                '308' => '308 Permanent Redirect',
            ]])
            ->add('stopped', null, ['required' => false])
            ->add('priority', TextType::class, [
                'sonata_help' => $this->trans('form_priority_description', [], 'SeoBundle'),
            ]);
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
