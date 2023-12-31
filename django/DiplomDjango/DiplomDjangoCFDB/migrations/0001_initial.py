# Generated by Django 4.2.7 on 2023-11-30 20:18

import datetime
from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='AppTypes',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('type', models.CharField(max_length=110, verbose_name='Тип аппарата')),
            ],
            options={
                'verbose_name': 'app_types',
            },
        ),
        migrations.CreateModel(
            name='People',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('initials', models.CharField(max_length=255, verbose_name='Инициалы')),
                ('surename', models.CharField(max_length=255, verbose_name='Фамилия')),
                ('name', models.CharField(max_length=255, verbose_name='Имя')),
                ('last_name', models.CharField(max_length=255, verbose_name='Отчество')),
            ],
            options={
                'verbose_name': 'people',
            },
        ),
        migrations.CreateModel(
            name='Roles',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('role_name', models.CharField(max_length=30, verbose_name='Роль')),
            ],
            options={
                'verbose_name': 'roles',
            },
        ),
        migrations.CreateModel(
            name='RolesRaisers',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('role_name', models.CharField(max_length=30, verbose_name='Роль')),
            ],
            options={
                'verbose_name': 'rolesraisers',
            },
        ),
        migrations.CreateModel(
            name='Users',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('nick_name', models.CharField(max_length=255, verbose_name='Имя пользователя')),
                ('email', models.CharField(max_length=255, verbose_name='Электронная почта')),
                ('password', models.CharField(max_length=255, verbose_name='Пароль')),
                ('role', models.ForeignKey(null=True, on_delete=django.db.models.deletion.PROTECT, to='DiplomDjangoCFDB.roles', verbose_name='roles')),
                ('role_raise', models.ForeignKey(null=True, on_delete=django.db.models.deletion.PROTECT, to='DiplomDjangoCFDB.rolesraisers', verbose_name='rolesraisers')),
            ],
            options={
                'verbose_name': 'users',
            },
        ),
        migrations.CreateModel(
            name='SpaceAchiv',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('country', models.CharField(max_length=6, verbose_name='Страна')),
                ('achiv_name', models.CharField(max_length=255, verbose_name='Наименование достижения')),
                ('date', models.DateField(default=datetime.date.today, verbose_name='Дата')),
                ('text', models.TextField(verbose_name='Описание')),
                ('people', models.ManyToManyField(to='DiplomDjangoCFDB.people', verbose_name='people')),
                ('type_app', models.ForeignKey(null=True, on_delete=django.db.models.deletion.PROTECT, to='DiplomDjangoCFDB.apptypes', verbose_name='app_types')),
            ],
            options={
                'verbose_name': 'space_achiv',
            },
        ),
    ]
