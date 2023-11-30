from django.db import models
from datetime import date

class AppTypes(models.Model):

    type = models.CharField("Тип аппарата", max_length=110)  

    class Meta:
        
        verbose_name = "app_types"


class People(models.Model):

    initials = models.CharField("Инициалы", max_length=255)  
    surename = models.CharField("Фамилия", max_length=255)  
    name = models.CharField("Имя", max_length=255)  
    last_name = models.CharField("Отчество", max_length=255)  

    class Meta:
        
        verbose_name = "people"


class Roles(models.Model):

    ROLE_CHOICES = [
        ("admin","Администратор"),
        ("operator","Оператор БД"),
        ("moderator","Модератор"),
        ("user","Пользователь"),
    ]
    
    role_name = models.CharField("Роль", max_length=9, choices=ROLE_CHOICES, default="user")  

    class Meta:
        
        verbose_name = "roles"
        
class RolesRaisers(models.Model):

    ROLE_CHOICES = [
        ("admin","Администратор"),
        ("operator","Оператор БД"),
        ("moderator","Модератор"),
        ("user","Пользователь"),
    ]

    role_name = models.CharField("Роль", max_length=9, choices=ROLE_CHOICES, default="user")  

    class Meta:
        
        verbose_name = "rolesraisers"


class SpaceAchiv(models.Model):

    country = models.CharField("Страна", max_length=6)  
    people = models.ManyToManyField(People, verbose_name = "people")  
    achiv_name = models.CharField("Наименование достижения", max_length=255)  
    date = models.DateField("Дата", default=date.today)  
    text = models.TextField("Описание")  
    type_app = models.ForeignKey(AppTypes, verbose_name = "app_types", on_delete=models.PROTECT, null=True)

    class Meta:
        
        verbose_name = "space_achiv"


class Users(models.Model):

    nick_name = models.CharField("Имя пользователя", max_length=255)  
    role = models.ForeignKey(Roles, verbose_name = "roles", on_delete=models.PROTECT, null=True)
    role_raise = models.ForeignKey(RolesRaisers, verbose_name = "rolesraisers", on_delete=models.PROTECT, null=True)  
    email = models.CharField("Электронная почта", max_length=255)  
    password = models.CharField("Пароль", max_length=255)  

    class Meta:
        
        verbose_name = "users"
