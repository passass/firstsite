from django.db import models
from django.contrib.auth.models import User


class Todos(models.Model):
    id = models.AutoField(primary_key=True)
    title = models.CharField(default="", max_length=60)
    text = models.CharField(default="", max_length=250)
    finished = models.BooleanField(default=False)
    whose = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self):
        return self.title
