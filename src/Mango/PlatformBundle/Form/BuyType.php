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
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Mango\PlatformBundle\Entity\Region;
use Mango\PlatformBundle\Entity\Departement;


class BuyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',     TextType::class)
            ->add('price', IntegerType::class)
            ->add('size', IntegerType::class)
            ->add('nbParts', IntegerType::class)
            ->add('userId',    HiddenType::class)
            ->add('content',   TextareaType::class)
            ->add('image',     ImageType::class)
            ->add('type', EntityType::class, array(    //Permet de faire un <select>
                    'class'        => 'MangoPlatformBundle:Type',
                    'placeholder'  => '-- Sélectionnez le type de bien --',
                    'choice_label' => 'name',
                    'multiple'     => false,
            ))
            ->add('region', EntityType::class, array(    //Permet de faire un <select>
                    'class'        => 'MangoPlatformBundle:Region',
                    'placeholder'  => '-- Sélectionnez votre région --',
                    'choice_label' => 'name',
                    'multiple'     => false,
            ))

            ->get('region')->addEventListener(
                FormEvents::POST_SUBMIT,
                function(FormEvent $event){
                    $form = $event->getForm();
                    $this-> addDepartementField($form->getParent(), $form->getData()); //Appel la méthode pour construire l'input departement   
                }
            );

        $builder->addEventListener(
              FormEvents::POST_SET_DATA,
              function (FormEvent $event) {
                $data = $event->getData();
                /* @var $ville Ville */
                $ville = $data->getCity();
                $form = $event->getForm();
                if ($ville) {
                  // On récupère le département et la région
                  $departement = $ville->getDepartement();
                  $region = $departement->getRegion();
                  // On crée les 2 champs supplémentaires
                  $this->addDepartementField($form, $region);
                  $this->addCityField($form, $departement);
                  // On set les données
                  $form->get('region')->setData($region);
                  $form->get('departement')->setData($departement);
                }else {
                    // On crée les 2 champs en les laissant vide (champs utilisé pour le JavaScript)
                    $this->addDepartementField($form, null);
                    $this->addCityField($form, null);
                }
            }
        );
    }

   private function addDepartementField(FormInterface $form, ?Region $region)
    {
      $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
        'departement',
        EntityType::class,
        null,
        [
          'class'           => 'MangoPlatformBundle:Departement',
          'placeholder'     => $region ? ' -- Sélectionnez votre département --' : '-- Veuillez sélectionnez une région avant --',
          'auto_initialize' => false,
          'choices'         => $region ? $region->getDepartements() : []
        ]
      );

      $builder->addEventListener(
        FormEvents::POST_SUBMIT,
        function (FormEvent $event) {
          $form = $event->getForm();
          $this->addCityField($form->getParent(), $form->getData());
        }
      );

      $form->add($builder->getForm());
    }

    private function addCityField(FormInterface $form, ?Departement $departement)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'city',
            EntityType::class,
            null,
            [
              'class'           => 'MangoPlatformBundle:City',
              'placeholder'     => $departement ? '-- Sélectionnez votre ville --' : '-- Veuillez sélectionnez un département avant --',
              'auto_initialize' => false,
              'choices'         => $departement ? $departement->getCities() : []
            ]
          );
          
          $form->add($builder->getForm());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mango\PlatformBundle\Entity\Buy'   //Définition de l'objet en lien avec le formulaire
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mango_platformbundle_buy';
    }


}