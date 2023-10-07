from django.contrib import auth
from django.contrib.auth import logout
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from django.contrib.auth.views import LoginView
from django.http import HttpResponseNotFound, JsonResponse
from django.shortcuts import render, redirect

from .forms import LoginUserForm, RegisterUserForm
from .models import *


def index(request):
    return render(request, 'main.html')


def register(request):
    args = {
        'title': "Авторизация",
        'form': RegisterUserForm,
        'error': False,
    }
    if request.method == "POST":
        form = RegisterUserForm(request.POST)
        if form.is_valid():
            login = form.cleaned_data['username']
            password = form.cleaned_data['password1']
            email = form.cleaned_data['email']
            print("register")
            if not User.objects.filter(username=login) and not User.objects.filter(email=email):
                user = User.objects.create_user(username=login,
                                                email=email,
                                                password=password)
                auth.login(request, user)
                return redirect('home')
            args["error"] = ["Почта или Логин уже заняты"]
        else:
            args['error'] = list(form.errors.values())[0]
        args['form'] = form
    return render(request, 'register.html', context=args)


@login_required
def todos(request):
    args = {
        'title': "Список дел",
        'todos': [],
    }
    args["todos"] = Todos.objects.filter(whose=request.user)
    return render(request, "todos.html", context=args)


def login(request):
    args = {
        'title': "Авторизация",
    }
    if request.method == "POST":
        form = LoginUserForm(request.POST)
        if form.is_valid():
            username = form.cleaned_data['username']
            password = form.cleaned_data['password']
            remember_me = form.cleaned_data['remember_me']
            user = auth.authenticate(username=username, password=password)
            if user:
                auth.login(request, user)
                if not remember_me:
                    request.session.set_expiry(0)
                return redirect('home')
            args["error"] = "Неверный логин или пароль"
    return render(request, 'login.html', context=args)


class LoginUser(LoginView):
    form_class = LoginUserForm
    template_name = 'login.html'

    def get_context_data(self, *, object_list=None, **kwargs):
        context = super().get_context_data(**kwargs)
        return dict(list(context.items()))

    def form_valid(self, form):
        user = form.get_user()
        auth.login(self.request, user)
        if "remember_me" in self.request.POST:
            self.request.session.set_expiry(0)
        return redirect('home')


def logout_view(request):
    logout(request)
    return redirect("home")


def about(request):
    return render(request, 'about.html')


def pageNotFound(request, exception):
    return HttpResponseNotFound('<h1>Страница не найдена</h1>'
                                '<p><a href=\'{% url "home" %}\'>на главную</a></p>')
