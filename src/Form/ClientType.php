<?php

namespace App\Form;

use App\Entity\Client;
use App\Enum\EducationEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Фамилия',
                'attr' => [
                    'placeholder' => 'Введите фамилию',
                    'autocomplete' => 'family-name',
                ],
                'required' => true,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Имя',
                'attr' => [
                    'placeholder' => 'Введите имя',
                    'autocomplete' => 'given-name',
                ],
                'required' => true,
            ])
            ->add('phone', TelType::class, [
                'label' => 'Номер телефона',
                'attr' => [
                    'placeholder' => '+7 (999) 123-45-67',
                ],
                'required' => true,
                'constraints' => [
                    new NotNull(
                        message: 'Номер телефона обязателен'
                    ),
                    new Regex(
                        pattern: '/^(\+7|8)[\s\-]?\(?\d{3}\)?[\s\-]?\d{3}[\s\-]?\d{2}[\s\-]?\d{2}$/',
                        message: 'Введите корректный российский номер телефона (например: +7 (999) 123-45-67 или 89991234567)'
                    ),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'example@email.com',
                    'autocomplete' => 'email',
                ],
                'required' => true,
                'constraints' => [
                    new NotNull(message: 'Email обязателен'),
                    new Email(
                        message: 'Введите корректный email адрес',
                        mode: 'html5',
                    )],
            ])
            ->add('educationType', EnumType::class, [
                'label' => 'Образование',
                'class' => EducationEnum::class,
                'choice_label' => 'label',
                'placeholder' => 'Выберите тип образования',
                'required' => true,
                'constraints' => [
                    new NotNull(message: 'Выберите тип образования'),
                ],
            ])
            ->add('isAgreement', CheckboxType::class, [
                'label' => 'Я согласен на обработку персональных данных',
                'required' => true,
                'mapped' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
