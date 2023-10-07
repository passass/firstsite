from django.urls import path, re_path
from django.contrib.auth.views import LogoutView

from .forms import *
from .views import *

urlpatterns = [
    path('', index, name='home'),
    path('about/', about, name='about'),
    path('login/', LoginUser.as_view(), name='login'),
    path('register/', register, name='register'),
    path('todo/', todos, name='todos'),
    path('todo/delete/', Todos_view_delete.as_view(), name='todos_delete'),
    path('todo/create/', Todos_view_put.as_view(), name='todos_create'),
    path('todo/controller/', Todos_view_post.as_view(), name='todos_controller'),
    path("logout/", logout_view, name="logout")
]
