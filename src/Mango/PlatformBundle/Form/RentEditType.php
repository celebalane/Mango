<?php

namespace Mango\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentEditType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
  	{
    	$builder
            ->add('title',     TextType::class)
            ->add('price', IntegerType::class)
            ->add('charge', IntegerType::class)
            ->add('size', IntegerType::class)
            ->add('nbParts', IntegerType::class)
            ->add('userId',    HiddenType::class)
            ->add('content',   TextareaType::class)
            ->add('image',     ImageType::class, array(
                    'required'     => false
            ))
            ->add('type', EntityType::class, array(    //Permet de faire un <select>
                    'class'        => 'MangoPlatformBundle:Type',
                    'placeholder'  => 'Sélectionnez le type de bien',
                    'choice_label' => 'name',
                    'multiple'     => false,
            ));
	}

   /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mango\PlatformBundle\Entity\Rent'   //Définition de l'objet en lien avec le formulaire
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mango_platformbundle_rent_edit';
    }
}
