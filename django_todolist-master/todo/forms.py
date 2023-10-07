import json

from django import forms
from django.contrib.auth.forms import UserCreationForm, AuthenticationForm
from django.contrib.auth.models import User
from django.core.exceptions import ValidationError
from django.http import HttpResponse, JsonResponse
from django.views import View

from todo.models import Todos


class LoginUserForm(AuthenticationForm):
    username = forms.CharField(widget=forms.TextInput(attrs={'class': 'form-input',
                                                                            'placeholder': 'Логин'}))
    password = forms.CharField(widget=forms.PasswordInput(attrs={'class': 'form-input',
                                                                            'placeholder': 'Пароль'}))
    remember_me = forms.BooleanField(required=False)


class RegisterUserForm(UserCreationForm):
    username = forms.CharField(widget=forms.TextInput(attrs={'class': 'form-input',
                                                                            'placeholder': 'Логин'}))
    email = forms.EmailField(widget=forms.EmailInput(attrs={'class': 'form-input',
                                                                            'placeholder': 'Почта'}))
    password1 = forms.CharField(widget=forms.PasswordInput(attrs={'class': 'form-input',
                                                                            'placeholder': 'Пароль'}))
    password2 = forms.CharField(widget=forms.PasswordInput(attrs={'class': 'form-input',
                                                                            'placeholder': 'Повторите пароль'}))

    class Meta:
        model = User
        fields = ('username', 'email', 'password1', 'password2')


'''def http_method_list(methods):
    def http_methods_decorator(func):
        def function_wrapper(self, request, **kwargs):
            nonlocal methods
            methods = [method.upper() for method in methods]
            if not request.method.upper() in methods:
                return HttpResponse(status=405) # not allowed

            return func(self, request, **kwargs)
        return function_wrapper
    return http_methods_decorator'''


class Todos_view_delete(View):
    def post(self, request):
        data = request.POST
        try:
            row_id = int(data["row_id"])
        except Exception:
            return JsonResponse({'status': 'error'})
        todo_rows = Todos.objects.filter(whose=request.user)
        print(todo_rows, len(todo_rows), row_id - 1)
        todo_rows[row_id - 1].delete()
        return JsonResponse({'status': 'ok'})


class Todos_view_put(View):
    def post(self, request):
        todo_row = Todos(whose=request.user)
        todo_row.save()
        return JsonResponse({'status': 'ok'})


class Todos_view_post(View):
    def post(self, request):
        data = json.loads(request.POST["json"])
        if len(data) != len(Todos.objects.all()):
            return JsonResponse({'status': 'error'})
        todo_rows = Todos.objects.filter(whose=request.user)
        for i, x in enumerate(data):
            todo_row = todo_rows[i]
            todo_row.title = x["title"]
            todo_row.text = x["text"]
            todo_row.finished = x["finished"]
            todo_row.save()
        return JsonResponse({'status': 'ok'})