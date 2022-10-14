<?php

namespace App\Controller\Admin;

use App\Entity\Security\UsuarioChat;
use App\Repository\Security\UsuarioChatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Services\Chat\MyChatService;

/**
 * @Route("/administracion/chat")
 * IsGranted("ROLE_ADMIN", "ROLE_GEST_CHAT")
 */
class ChatController extends AbstractController
{

    /**
     * @Route("/", name="app_chat_index", methods={"GET"})
     * @param UsuarioChatRepository $usuarioChatRepository
     * @return Response
     */
    public function index(UsuarioChatRepository $usuarioChatRepository)
    {
        try {
            return $this->render('modules/admin/chat/index.html.twig', [
                'registros' => $usuarioChatRepository->findBy([], ['id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
        }
    }   
    
    /**
     * @Route("/testConn", name="app_chat_con", methods={"GET", "POST"})
     * @param MyChatService $usuarioChat
     * @return Response
     */
    public function testConnection(MyChatService $myChatService)
    {    
        $conInfo = $myChatService->testConnection();

        return $this->render('modules/admin/chat/conect.html.twig', [
            'item' => $conInfo,
        ]);
    }
    
    /**
     * @Route("/{id}/detail", name="app_chat_detail", methods={"GET", "POST"})
     * @param UsuarioChat $usuarioChat
     * @return Response
     */
    public function detail(UsuarioChat $usuarioChat)
    {    
        return $this->render('modules/admin/chat/detail.html.twig', [
            'item' => $usuarioChat,
        ]);
    }

    /**
     * @Route("/{id}/sincronizar", name="app_chat_sincronizar", methods={"GET"})
     * @param UsuarioChat $usuarioChat
     * @param MyChatService $myChatService
     * @return Response
     */
    public function sincronizar(UsuarioChat $usuarioChat, MyChatService $myChatService )
    {       
        try {
            $myChatService->sincronizarUsuarioChat($usuarioChat);
            $this->addFlash('success', 'El usuario ha sido sincronizado satisfactoriamente.');
        } 
        catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());            
        }
       
        return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/test", name="app_chat_test", methods={"GET"})
     * @param MyChatService $usuarioChat
     * @return Response
     */
    public function test(MyChatService $myChatService)
    {    
        $myChatService->test();

        die;
    }
}
