from django.contrib.auth.models import AbstractUser
from django.db import models

# Create your models here.
class User(AbstractUser):
    pass
    avatar = models.ImageField(upload_to='images/', blank=True)