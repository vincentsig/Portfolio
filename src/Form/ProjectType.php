<?php

namespace App\Form;

use App\Entity\Techno;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('technos', EntityType::class, [
                'class' => Techno::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('content', CKEditorType::class, [
                'config_name' => 'basic_config',
                'label' => 'ckeditor',
            ])
            ->add('urlGithub', UrlType::class)
            ->add('urlWebsite', UrlType::class)
            ->add('slug', TextType::class)
            ->add('media', MediaType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
