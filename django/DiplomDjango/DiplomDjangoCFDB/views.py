from django.shortcuts import render
from django.http import HttpResponse
from django.http import HttpResponseNotFound

class database:

    def main(request):
        return HttpResponse("База данных")
    def get_role_database(request, role_database):
        role_databaseS = {
        'database':'База данных для отображения пользователю',
        'moderation_database':'База данных для отображения модератору',
        'opration_database':'База данных для отображения оператору БД',
        'admin_database':'База данных для отображения админу',
        }
        content = role_databaseS.get(role_database)
        
        if content:
            return HttpResponse(content)
        else:
            return HttpResponseNotFound(f"Неизвестная база данных - {role_database}")

