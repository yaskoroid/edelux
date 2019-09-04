<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.19
 * Time: 21:50
 */

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemUpdate extends AbstractItem
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('id', IntegerType::class);
    }
}