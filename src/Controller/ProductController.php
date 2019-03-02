<?php

namespace App\Controller;

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


class ProductController extends AbstractController
{
	/**
	* @Route("/", name="product_list")
	*/
	public function index()
    {
		$repository = $this->getDoctrine()->getRepository(Product::class);
		$products = $repository->findAll();
		return $this->render('product/index.html.twig', array('products'=>$products));
    }
	/**
	* @Route("/product/show/{id}", name="product_show")
	*/
	public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
		$product = $repository->find($id);
		return $this->render('product/show.html.twig', array('product'=>$product));
    }
	/**
	* @Route("/product/delete/{id}", name="product_delete")
	*/
	public function delete(Request $request, $id)
    {
		//die('delete function');	
        $repository = $this->getDoctrine()->getRepository(Product::class);
		$product = $repository->find($id);
		//print_r($product); die('ok');
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($product);
		$entityManager->flush();
		$response = new Response();
		return $response;
    }
	
	/**
	* @Route("/product/new", name="new_product")
	* Method({"GET","POST"})
	*/
	public function new(Request $request)
	{
		$product = new Product();
		$form = $this->createFormBuilder($product)
			->add('name', TextType::class, array('attr'=>array('class'=>'form-control')))
			->add('price', TextType::class, array('attr'=>array('class'=>'form-control')))
			->add('stockAvailable', TextType::class, array('attr'=>array('class'=>'form-control')))
			->add('status', ChoiceType::class, array( 'choices'  => [
					'In Stock' => 'In Stock',
					'Pre Order' => 'Pre Order',
					'Out Of Stock' => 'Out Of Stock',
				], 'attr'=>array('class'=>'form-control')))
			->add('category', EntityType::class, [
				'class' => 'App\Entity\Category',
				'multiple' => false,
				'attr'=>array('class'=>'form-control')
			])
			->add('Save', SubmitType::class, array('label'=>'Add Product','attr'=>array('class'=>'btn btn-primary mt-3')))
			->getForm();
		
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			$product = $form->getData();
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($product);
			$entityManager->flush();
			return $this->redirectToRoute('product_list');
			
		}
		return $this->render('product/new.html.twig', array('form'=> $form->createView()));
	}
	
	/**
	* @Route("/product/edit/{id}", name="edit_product")
	* Method({"GET","POST"})
	*/
	public function edit(Request $request, $id)
	{
		$product = new Product();
		$repository = $this->getDoctrine()->getRepository(Product::class);
		$product = $repository->find($id);
		$form = $this->createFormBuilder($product)
			->add('name', TextType::class, array('attr'=>array('class'=>'form-control')))
			->add('price', TextType::class, array('attr'=>array('class'=>'form-control')))
			->add('stockAvailable', TextType::class, array('attr'=>array('class'=>'form-control')))
			->add('status', ChoiceType::class, array( 'choices'  => [
					'In Stock' => 'In Stock',
					'Pre Order' => 'Pre Order',
					'Out Of Stock' => 'Out Of Stock',
				], 'attr'=>array('class'=>'form-control')))
			->add('category', EntityType::class, [
				'class' => 'App\Entity\Category',
				'multiple' => false,
				'attr'=>array('class'=>'form-control')
			])
			->add('Save', SubmitType::class, array('label'=>'Update Product','attr'=>array('class'=>'btn btn-primary mt-3')))
			->getForm();
		
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($product);
			$entityManager->flush();
			return $this->redirectToRoute('product_list');
			
		}
		return $this->render('product/edit.html.twig', array('form'=> $form->createView()));
	}
	
	
	
}