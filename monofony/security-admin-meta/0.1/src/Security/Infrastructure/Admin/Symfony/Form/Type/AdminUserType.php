<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Admin\Symfony\Form\Type;

use App\Security\Infrastructure\Admin\Sylius\Resource\AdminUserResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'app.form.user.email',
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'app.form.user.password',
            ])
        ;
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => AdminUserResource::class,
            ])
        ;
    }

    #[\Override]
    public function getBlockPrefix(): string
    {
        return 'sylius_admin_user';
    }
}
