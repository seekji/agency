<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Security\Admin\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/login/", name="admin.login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $form = $this->createForm(LoginForm::class, [
            'username' => $authenticationUtils->getLastUsername()
        ]);

        return $this->render('admin/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'form' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }
}
