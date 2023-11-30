from django.contrib import admin
from django.urls import path
from django.template.loader import render_to_string
from DiplomDjangoCFDB.views import database

urlpatterns = [
    path('admin/', admin.site.urls),
    path('database/<role_database>', database.get_role_database),
]
