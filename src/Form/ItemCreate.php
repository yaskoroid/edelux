<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.19
 * Time: 16:19
 */

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;

class ItemCreate extends AbstractItem
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }
}