<?php

namespace AppBundle\Form;

use AppBundle\Entity\Subscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\ContactType;
use AppBundle\Form\ProductType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubscriptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('contact')
        ->add('product')
        ->add('beginDate', DateType::class, [
            'widget' => 'single_text',
            'input' => 'datetime',
            'format' => DateType::HTML5_FORMAT,
        ])
        ->add('endDate', DateType::class, [
            'widget' => 'single_text',
            'input' => 'datetime',
            'format' => DateType::HTML5_FORMAT,
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Subscription::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_subscription';
    }


}
