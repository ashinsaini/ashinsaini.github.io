from django.urls import path
from . import views

urlpatterns = [
    path("login", views.login_view, name="login"),
    path("logout", views.logout_view, name="logout"),
    path("register", views.register, name="register"),
    path("", views.index, name="index"),
    path("symbol/", views.symbol, name="symbol"),
    path("chart/<str:id>/<int:days>", views.chart, name="chart")
]