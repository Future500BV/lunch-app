<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Shop;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LunchController extends AbstractController
{
    /**
     * @Route("/pick-lunch/{userId}", name="pick-shop")
     */
    public function pickLunch(EntityManagerInterface $entityManager, Request $request, int $userId)
    {
        $userRepository = $entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($userId);

        $shopRepository = $entityManager->getRepository(Shop::class);
        /** @var Shop[] $shops */
        $shops          = $shopRepository->findAll();

        $choices = [];
        foreach($shops as $shop)
        {
            $choices[$shop->getName()] = $shop->getId();
        }

        $form = $this->createFormBuilder()
            ->add('shop', ChoiceType::class, ['choices' => $choices] )
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ( ($form->isSubmitted()) && ($form->isValid()))
        {
            $formData = $form->getData();
            $this->redirectToRoute('pick-products', ['shopId' => $formData['shop'], 'userId' => $user->getId()]);
        }

        return $this->render(
            'pick-lunch.html.twig',
            [
                'form'     => $form->createView(),
                'username' => $user->getName(),
            ]
        );
    }

    /**
     * @Route("/pick-product/{userId}/{shopId}", name="pick-products")
     */
    public function pickProduct(EntityManagerInterface $entityManager, Request $request, int $shopId, int $userId)
    {
        $userRepository = $entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($userId);

        $productRepository = $entityManager->getRepository(Product::class);
        /** @var Product[] $products */
        $products = $productRepository->findBy(['shopId' => $shopId]);

        $shopRepository = $entityManager->getRepository(Shop::class);
        /** @var Shop $shop */
        $shop          = $shopRepository->find($shopId);

        $choices = [];
        foreach($products as $product)
        {
            $choices[$product->getName()] = $product->getId();
        }

        $form = $this->createFormBuilder()
            ->add('product', ChoiceType::class, ['choices' => $choices] )
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ( ($form->isSubmitted()) && ($form->isValid()))
        {
            $formData = $form->getData();
            var_dump($formData);die;
            $this->redirectToRoute('succes', ['userId' => $user->getId()]);
        }

        return $this->render(
            'pick-product.html.twig',
            [
                'form'     => $form->createView(),
                'shopname' => $shop->getName(),
                'username' => $user->getName(),
            ]
        );
    }
}
