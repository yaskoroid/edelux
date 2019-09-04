<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.19
 * Time: 21:40
 */

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AbstractItem extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateTime', DateTimeType::class, [
                'format'   => 'yyyy-MM-dd HH:mm:ss',
                'widget'   => 'single_text',
                'required' => true,
            ])
            ->add('message', TextType::class, [
                'constraints' => new Length(['max' => 1024]),
            ])
            ->add('owner', TextType::class)
            ->add('version', IntegerType::class)
            ->add('save', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Item::class,
            'csrf_protection' => false,
        ]);
    }
}