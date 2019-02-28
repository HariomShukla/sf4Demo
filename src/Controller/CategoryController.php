<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategoryController extends AbstractController
{
	/**
	* @Route("/category", name="category_list")
	*/
	public function index()
    {
		$repository = $this->getDoctrine()->getRepository(Category::class);
		$categorys = $repository->findAll();
		return $this->render('category/index.html.twig', array('categorys'=>$categorys));
    }
	/**
	* @Route("/category/show/{id}", name="category_show")
	*/
	public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
		$category = $repository->find($id);
		return $this->render('category/show.html.twig', array('category'=>$category));
    }
	/**
	* @Route("/category/delete/{id}", name="category_delete")
	*/
	public function delete(Request $request, $id)
    {
		//die('delete function');	
        $repository = $this->getDoctrine()->getRepository(Category::class);
		$category = $repository->find($id);
		//print_r($category); die('ok');
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($category);
		$entityManager->flush();
		$response = new Response();
		return $response;
    }
	
	/**
	* @Route("/category/new", name="new_category")
	* Method({"GET","POST"})
	*/
	public function new(Request $request)
	{
		$category = new category();
		$product = new Product();
		
		$form = $this->createFormBuilder($category)
			->add('categoryName', TextType::class, array('attr'=>array('class'=>'form-control')))
			->add('products', EntityType::class, [
				'class' => 'App\Entity\Product',
				'multiple' => false,
				'attr'=>array('class'=>'form-control')
			])
			->add('Save', SubmitType::class, array('label'=>'Add category','attr'=>array('class'=>'btn btn-primary mt-3')))
			->getForm();
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			$category = $form->getData();
			//$category = $form->product->getData();
			// echo "<pre>";
			// print_r($category); die;
			// $productEntity = $this->em->getReposiroty('AppBundle:Product')->find
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($category);
			$entityManager->flush();
			return $this->redirectToRoute('category_list');
			
		}
		return $this->render('category/new.html.twig', array('form'=> $form->createView()));
	}
	
	/**
	* @Route("/category/edit/{id}", name="edit_category")
	* Method({"GET","POST"})
	*/
	public function edit(Request $request, $id)
	{
		$category = new category();
		$repository = $this->getDoctrine()->getRepository(Category::class);
		$category = $repository->find($id);
		$form = $this->createFormBuilder($category)
			->add('categoryName', TextType::class, array('attr'=>array('class'=>'form-control')))
			->add('Save', SubmitType::class, array('label'=>'Update category','attr'=>array('class'=>'btn btn-primary mt-3')))
			->getForm();
		
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($category);
			$entityManager->flush();
			return $this->redirectToRoute('category_list');
			
		}
		return $this->render('category/edit.html.twig', array('form'=> $form->createView()));
	}
	
	/**
	* @Route("/about", name="about")
	*/
	public function about()
    {
		return $this->render('about.html.twig');
    }
	
	
	
}