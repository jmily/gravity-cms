<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 29/02/2016
 * Time: 5:43 PM
 */

namespace AppBundle\Controller\Admin;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use AppBundle\Form\Type\CategoryType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductController extends Controller
{
    /**
     * @Route("/admin/product/list", name="admin_product_list")
     */
    public function listAction(Request $request)
    {

        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();
        $category = new Category();

        $product = new Product();

        $product->addCategory($category);


        $form = $this->createFormBuilder($product)
            ->add('name',TextType::class,array('label'=>'产品名称'))
            ->add('brand', EntityType::class,array(
                'class' => 'AppBundle\Entity\Brand',
                'query_builder' => function (EntityRepository $br) {
                    return $br->createQueryBuilder('b');
                },
                'choice_label' => 'name',
                'required' => true,
                'label' => '添加品牌'
            ))
            ->add('price',MoneyType::class, array(
                'divisor' => 100,
                'label' => '产品价格',
                'currency' => ''
            ))
            ->add('categories', CollectionType::class, array(
                  'entry_type' => CategoryType::class,
                  'allow_add' => true,
              ))
            ->add('save',SubmitType::class, array('label'=>'确认产品'))
            ->getForm();

        return $this->render('admin/product_list.html.twig',array('products'=>$products, 'form'=>$form->createView()));
    }

}