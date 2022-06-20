from django.contrib import admin
from .models import User,Ticker

# Register your models here.

admin.site.register(User),
admin.site.register(Ticker)