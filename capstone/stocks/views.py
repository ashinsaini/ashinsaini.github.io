from django.shortcuts import render

# Create your views here.
from django.shortcuts import render
from django.http import HttpResponse, JsonResponse, HttpResponseRedirect
from django.db import IntegrityError
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.urls import reverse
from django.conf import settings
import yahoo_fin.stock_info as si
import sys, json,os
import pandas as pd
import numpy as np
from .models import User

def index(request):
    if request.user.is_authenticated:
        superuser = request.user
        return render(request, "stocks/index.html", {
            "superuser":superuser
        })
    else:
        return HttpResponseRedirect(reverse("login"))
   
def login_view(request):
    if request.method == "POST":

        # Attempt to sign user in
        username = request.POST["username"]
        password = request.POST["password"]
        user = authenticate(request, username=username, password=password)

        # Check if authentication successful
        if user is not None:
            login(request, user)
            return HttpResponseRedirect(reverse("index"))
        else:
            return render(request, "stocks/login.html", {
                "message": "Invalid username and/or password."
            })
    else:
        return render(request, "stocks/login.html")


def logout_view(request):
    logout(request)
    return HttpResponseRedirect(reverse("index"))

def register(request):
    if request.method == "POST":
        username = request.POST["username"]
        email = request.POST["email"]
        avatar = request.FILES["avatar"]
        # Ensure password matches confirmation
        password = request.POST["password"]
        confirmation = request.POST["confirmation"]
        if password != confirmation:
            return render(request, "stocks/register.html", {
                "message": "Passwords must match."
            })
        if avatar == '':
             return render(request, "stocks/register.html", {
                "message": "Must choose avatar."
            })
        # Attempt to create new user
        try:
            user = User.objects.create_user(username, email, password)
            user.avatar = avatar
            user.save()
            initial_path = user.avatar.path
            user.avatar.name='/images/avatar-{}'.format(username)
            new_path = settings.MEDIA_ROOT + user.avatar.name
            os.rename(initial_path,new_path)
            user.save()
        except IntegrityError:
            return render(request, "stocks/register.html", {
                "message": "Username already taken."
            })
        login(request, user)
        return HttpResponseRedirect(reverse("index"))
    else:
        return render(request, "stocks/register.html")

@login_required
def symbol(request):
    if request.method == 'POST':
        symbol = request.POST["symbol"]
        out = si.get_live_price(symbol.capitalize())
        symbol_info = si.get_data(symbol).tail(10)
        output="{:.2f}".format(out)
        #histo_info = symbol_info['open'].plot()
        #graph(symbol_info)       
    return render(request, "stocks/output.html",{
        "output":output,
        "symbol":symbol.upper(),
        #"graph" :histo_info
    })
@login_required
def chart(request,id,days):
        ticker_info=si.get_data(id,index_as_date=False).tail(days)
        ticker = ticker_info.to_json()
        tick = json.loads(ticker)
        return JsonResponse(tick,safe=False)

