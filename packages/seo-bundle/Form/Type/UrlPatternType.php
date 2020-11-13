<?php

namespace Seo\SeoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UrlPatternType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();

                $normalized = parse_url($data, PHP_URL_PATH);

                if (false !== strpos($normalized, '/app_dev.php')) {
                    $normalized = substr($normalized, 12);
                }

                if ($query = parse_url($data, PHP_URL_QUERY)) {
                    $normalized .= '?'.$query;
                }

                $event->setData($normalized);
            });
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'url_pattern';
    }
}
