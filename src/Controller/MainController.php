<?php

namespace App\Controller;


use App\Entity\Crud;
use App\Form\CrudType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()->getRepository(Crud::class)->findAll();

        return $this->render('main/index.html.twig', [
            'data'=> $data,

        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $crud =new Crud();
        $form=$this->createForm(CrudType::class,$crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($crud);
            $em->flush();
            $this->addFlash('success', 'Add data sucefully');
            return $this->redirectToRoute('main');
        }

        return $this->render('main/create.html.twig',[
            'form' => $form->createView(),
        ]);

    }



    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request ,$id): Response
    {

        $crud =$this->getDoctrine()->getRepository(Crud::class)->find($id);
        $form=$this->createForm(CrudType::class,$crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($crud);
            $em->flush();
            $this->addFlash('success', 'update data sucefully');
            return $this->redirectToRoute('main');
        }

        return $this->render('main/update.html.twig',[
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id): Response
    {

        $data =$this->getDoctrine()->getRepository(Crud::class)->find($id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'delete data sucefully');
            return $this->redirectToRoute('main');


        return $this->render('main/update.html.twig',[
            'form' => $form->createView(),
        ]);

    }

}
