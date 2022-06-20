from django.contrib.auth.models import AbstractUser
from django.db import models

# Create your models here.
class User(AbstractUser):
    pass
    avatar = models.ImageField(upload_to='images/', blank=True)

class Ticker(models.Model):
    symbol = models.CharField(max_length=20,null=False)
    description = models.CharField(max_length=100,null=False)
    exchange = models.CharField(max_length=10,null=False)
    
    def serialize(self):
        return{
            "id":self.id,
            "symbol":self.symbol,
            "description":self.description,
            "exchange":self.exchange
        }
    
    def __str__(self):
       return f"Symbol:{self.symbol}, Description: {self.description}, Exchange:{self.exchange}"