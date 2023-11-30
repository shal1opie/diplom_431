from django.contrib import admin
from .models import AppTypes,People,Roles,RolesRaisers,SpaceAchiv,Users

admin.site.register(AppTypes)
admin.site.register(People)
admin.site.register(Roles)
admin.site.register(RolesRaisers)
admin.site.register(SpaceAchiv)
admin.site.register(Users)

