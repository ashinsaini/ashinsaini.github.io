# Create your views here.
from django.shortcuts import render
from django.http import HttpResponse, JsonResponse, HttpResponseRedirect
from django.contrib.staticfiles import finders
from django.db import IntegrityError
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.urls import reverse
from django.conf import settings
from django.views.decorators.csrf import csrf_exempt
import yahoo_fin.stock_info as si
import sys, json,os,re
import pandas as pd
import numpy as np
from .models import User, Ticker

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

        s = request.POST["symbol"]
        if s == '':
          return render(request, "stocks/index.html",{
                "message":"No stock data found, please check the symbol used."
            })

        rgex= re.search('[|]',s)
        egex= re.search('[_]',s)
        symbol = s[0:rgex.start()]
        exchange = s[egex.end():len(s)]
        x = Ticker.objects.filter(description__contains=symbol)
        xxsym = x[0].symbol
        xxdesc = x[0].description
        superuser = request.user
        if len(x) >= 2:
            x = x.filter(exchange__contains=exchange)
            xchg = x[0].exchange
            xsym = x[0].symbol
            xdesc = x[0].description
            if xchg == 'TSX':
                sy = xsym + '.TO'
                out = si.get_live_price(sy)
                i = si.get_quote_table(sy)
                info = list(i.values())

                if out:
                    output="{:.2f}".format(out)
                    return render(request, "stocks/output.html",{
                "superuser":superuser,
                "desc":xdesc,
                "output":output,
                "symbol":sy,
                "52_Week_Range": info[1], "Ask":info[2], "Avg_Volume":info[3], "Bid": info[5], "Days_Range": info[6], "Market_Cap":info[11], "Open":info[12], "Previous_Close": info[14]
                })
                else:
                    return render(request, "stocks/index.html",{
                "message":"No stock data found, please check the symbol used."
                })
            elif xchg == 'TSXV':
                sy = xsym + '.V'
                out = si.get_live_price(sy)
                i = si.get_quote_table(sy)
                info = list(i.values())

                if out:
                    output="{:.2f}".format(out)
                    return render(request, "stocks/output.html",{
                "superuser":superuser,
                "desc":xdesc,
                "output":output,
                "symbol":sy,
                "52_Week_Range": info[1], "Ask":info[2], "Avg_Volume":info[3], "Bid": info[5], "Days_Range": info[6], "Market_Cap":info[11], "Open":info[12], "Previous_Close": info[14]
                    })
                else:
                    return render(request, "stocks/index.html",{
                "message":"No stock data found, please check the symbol used."
                })
            elif xchg is 'NYSE' or 'AMEX' or 'NASDAQ':
                out = si.get_live_price(xsym)
                i = si.get_quote_table(xsym)
                info = list(i.values())
                if out:
                    output="{:.2f}".format(out)
                    return render(request, "stocks/output.html",{
                "superuser":superuser,
                "desc":xdesc,
                "output":output,
                "symbol":xsym,
                "52_Week_Range": info[1], "Ask":info[2], "Avg_Volume":info[3], "Bid": info[5], "Days_Range": info[6], "Market_Cap":info[11], "Open":info[12], "Previous_Close": info[14]
                })

                else:
                    return render(request, "stocks/index.html",{
                    "message":"No stock data found, please check the symbol used."
                    })

            elif si.get_live_price(xsym) is None:
                return render(request, "stocks/index.html",{
                "message":"No stock data found, please check the symbol used."
            })
        elif len(x) == 1:
            if re.search('[.]',xxsym):
                out = si.get_live_price(xxsym)
                i = si.get_quote_table(xxsym)
                info = list(i.values())

                output="{:.2f}".format(out)
                return render(request, "stocks/output.html",{
                "superuser":superuser,
                "desc":xxdesc,
                "output":output,
                "symbol":xxsym,
                "52_Week_Range": info[1], "Ask":info[2], "Avg_Volume":info[3], "Bid": info[5], "Days_Range": info[6], "Market_Cap":info[11], "Open":info[12], "Previous_Close": info[14]
                })
            elif exchange == 'TSX':
                    sy = xxsym +'.TO'
                    out = si.get_live_price(sy)
                    output="{:.2f}".format(out)
                    i= si.get_quote_table(sy)
                    info = list(i.values())

                    return render(request, "stocks/output.html",{
                "superuser":superuser,
                "desc":xxdesc,
                "output":output,
                "symbol":sy,
                "52_Week_Range": info[1], "Ask":info[2], "Avg_Volume":info[3], "Bid": info[5], "Days_Range": info[6], "Market_Cap":info[11], "Open":info[12], "Previous_Close": info[14]
                })

            elif exchange == 'TSXV':
                    sy = xxsym +'.V'
                    out = si.get_live_price(sy)
                    output="{:.2f}".format(out)
                    i = si.get_quote_table(sy)
                    info = list(i.values())

                    return render(request, "stocks/output.html",{
                "superuser":superuser,
                "desc":xxdesc,
                "output":output,
                "symbol":sy,
                "52_Week_Range": info[1], "Ask":info[2], "Avg_Volume":info[3], "Bid": info[5], "Days_Range": info[6], "Market_Cap":info[11], "Open":info[12], "Previous_Close": info[14]
                })
            else:
                out = si.get_live_price(xxsym)
                output="{:.2f}".format(out)
                i = si.get_quote_table(xxsym)
                info = list(i.values())

                return render(request, "stocks/output.html",{
                "superuser":superuser,
                "desc":xxdesc,
                "output":output,
                "symbol":xxsym,
                "52_Week_Range": info[1], "Ask":info[2], "Avg_Volume":info[3], "Bid": info[5], "Days_Range": info[6], "Market_Cap":info[11], "Open":info[12], "Previous_Close": info[14]
                })
    else:
        return render(request, "stocks/index.html",{
                "message":"No stock data found, please check the symbol used."
            })

@login_required
def chart(request,id,days):
    ticker_info=si.get_data(id,index_as_date=False).tail(days).dropna()
    ticker = ticker_info.to_json()
    tick = json.loads(ticker)
    if ticker == "":
        return render(request, "stocks/index.html",{
          "message":"Symbol is not found."
    })
    else:
        return JsonResponse(tick,safe=False)

@login_required
def symbol_search(request):
    result = finders.find('stocks/TSX.csv')
    ddf = pd.read_csv(result,sep='\t')
    vars = ddf.assign(Data=ddf['Description'] + ' : ' + ddf['Symbol'] + ':' + ddf['Exchange'])
    vvv = vars['Data']
    dff = vvv.to_json(orient = 'values')
    df = json.loads(dff)

    if df is None:
        return render(request, "stocks/index.html",{
            "message":"No company stock found."
        })
    else:
        return JsonResponse(df, safe=False)

@csrf_exempt
@login_required
def search(request):
    stock = request.GET.get('stock')
    payload = []
    if stock:
        ticker = Ticker.objects.filter(description__contains=stock)
        for i in ticker:
            payload.append(i.description + '| ' + i.symbol + ' _' + i.exchange)
    return JsonResponse(payload,safe=False)
