<?php

namespace App\Controller\Admin;


use App\Entity\Restaurant\Perfil;
use App\Entity\Security\User;
use App\Form\Restaurant\PerfilType;
use App\Repository\Restaurant\PerfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/administracion/perfil")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_FUNC")
 */
class PerfilController extends AbstractController
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @Route("/", name="app_perfil_index", methods={"GET"})
     * @param PerfilRepository $perfilRepository
     * @return Response
     */
    public function index(PerfilRepository $perfilRepository)
    {
        try {
            return $this->render('modules/restaurant/perfil/index.html.twig', [
                'registros' => $perfilRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_perfil_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_perfil_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param PerfilRepository $perfilRepository
     * @return Response
     */
    public function registrar(Request $request, PerfilRepository $perfilRepository, EntityManagerInterface $em)
    {
        try {
            $perfil = new Perfil();
            $form = $this->createForm(PerfilType::class, $perfil, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
//                $perfil->setNombre($perfil->getEmail());

                $user = new User();
                $user->setEmail($perfil->getEmail());
                $user->setRole('ROLE_CLIENT');
                $password = $this->hasher->hashPassword($user, $perfil->getPassword());
                $user->setPassword($password);

                $perfil->setUser($user);
                $em->persist($user);

                $perfilRepository->add($perfil, true);
                $em->flush();

                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_perfil_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/restaurant/perfil/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_perfil_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_perfil_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Perfil $perfil
     * @param PerfilRepository $perfilRepository
     * @return Response
     */
    public function modificar(Request $request, Perfil $perfil, PerfilRepository $perfilRepository)
    {
        try {
            $form = $this->createForm(PerfilType::class, $perfil, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
//                $perfil->setNombre($perfil->getEmail());

                $perfilRepository->edit($perfil);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_perfil_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/restaurant/perfil/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_perfil_modificar', ['id' => $perfil], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_perfil_eliminar", methods={"GET"})
     * @param Perfil $perfil
     * @param PerfilRepository $perfilRepository
     * @return Response
     */
    public function eliminar(Perfil $perfil, PerfilRepository $perfilRepository)
    {
        try {
            if ($perfilRepository->find($perfil) instanceof Perfil) {
                $perfilRepository->remove($perfil, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_perfil_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_perfil_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_perfil_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
