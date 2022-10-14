<?php

namespace App\Controller\Admin;

use App\Entity\Security\User;
use App\Form\Admin\CambiarClaveFormType;
use App\Form\Admin\UserChgPswFormType;
use App\Form\Admin\UserFormType;
use App\Repository\Security\UserRepository;
use App\Services\Chat\MyChatService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


//use Export\Admin\ExportListUsersToPdf;

/** 
 * @Route("/administracion/cambio_clave")
 */
class CambioClaveController extends AbstractController
{

    /**
     * @Route("/{id}/ejecutar", name="app_usuario_cambiar_clave", methods={"GET", "POST"})
     * @param Request $request
     * @param User $usuario
     * @param UserRepository $usuarioRepository
     * @param UserPasswordEncoderInterface $encoder
     * @param MyChatService $myChatService
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function cambiarContrasenna(Request $request, User $usuario, UserRepository $usuarioRepository, UserPasswordEncoderInterface $encoder, MyChatService $myChatService)
    {
        $form = $this->createForm(CambiarClaveFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->getData()->getPasswordPlainText() != "") {
                $encodedPassword = $encoder->encodePassword($usuario, $form->getData()->getPasswordPlainText());
                $usuario->setPassword($encodedPassword);
                $usuario->setPasswordChangeFirstTime(true);
            }

            $usuarioRepository->edit($usuario, true);

            //MYCHATSERVICE : 
            if ($form->getData()->getPasswordPlainText() != "")
            {
                $myChatService->resetPasswordForLoginUser($form->getData()->getPasswordPlainText());
            }

            $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
            return $this->redirectToRoute('app_dash_board', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->render('modules/admin/usuario/cambiar_clave.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
