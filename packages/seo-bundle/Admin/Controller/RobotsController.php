<?php

namespace Seo\SeoBundle\Admin\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/robots")
 */
class RobotsController extends AbstractController
{
    /**
     * @Route("/edit", name="seo.admin.robots.edit")
     * @Template("@Seo/Admin/Robots/edit.html.twig")
     */
    public function editAction(Request $request)
    {
        $robotsPath = $this->getParameter('kernel.root_dir').'/../public/robots.txt';

        $content = null;

        if (is_readable($robotsPath)) {
            $content = file_get_contents($robotsPath);
        }

        $form = $this->createFormBuilder(null, ['method' => 'POST']);
        $form = $form->add('content', TextareaType::class, ['data' => $content, 'attr' => ['rows' => 50]])->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            file_put_contents($robotsPath, $form->getData()['content']);

            return $this->redirectToRoute('seo.admin.robots.edit');
        }

        return [
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'base_template' => $this->container->getParameter('sonata.admin.configuration.templates')['layout'],
            'edit_template' => $this->container->getParameter('sonata.admin.configuration.templates')['edit'],
            'form' => $form->createView(),
        ];
    }
}
