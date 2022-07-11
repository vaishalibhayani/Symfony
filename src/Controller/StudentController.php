<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{

    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        $list=$this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('student/index.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/student/create", name="create")
     */
    public function create(Request $request): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            $this->addFlash('success', 'Add data sucefully');
            return $this->redirectToRoute('student');
        }

            return $this->render('student/create.html.twig', [
                'form' => $form->createView(),
            ]);
        }

    /**
     * @Route("/student/supdate{id}", name="supdate")
     */
    public function update(Request $request,$id): Response
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            $this->addFlash('success', 'Update data sucefully');
            return $this->redirectToRoute('student');
        }

        return $this->render('student/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/student/sdelete{id}", name="sdelete")
     */
    public function sdelete($id): Response
    {
        $data = $this->getDoctrine()->getRepository(Student::class)->find($id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'Delete data sucefully');
            return $this->redirectToRoute('student');


        return $this->render('student/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
