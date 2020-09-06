# library to launch and kill Tor process
import os
import subprocess

# library for Tor connection
import socket
import socks
import http.client
import time
import requests
from stem import Signal
from stem.control import Controller

# library for scraping
import csv
import urllib
from bs4 import BeautifulSoup
import time

def launchTor():
    # start Tor (wait 30 sec for Tor to load)
    sproc = subprocess.Popen(r'.../Tor Browser/Browser/firefox.exe')
    time.sleep(30)
    return sproc

def killTor(sproc):
    sproc.kill()

def connectTor():
    socks.setdefaultproxy(socks.PROXY_TYPE_SOCKS5, "127.0.0.1", 9150, True)
    socket.socket = socks.socksocket
    print("Connected to Tor")

def set_new_ip():
    # disable socks server and enabling again
    socks.setdefaultproxy()
    """Change IP using TOR"""
    with Controller.from_port(port=9151) as controller:
        controller.authenticate()
        socks.setdefaultproxy(socks.PROXY_TYPE_SOCKS5, "127.0.0.1", 9150, True)
        socket.socket = socks.socksocket
        controller.signal(Signal.NEWNYM)

def checkIP():
    conn = http.client.HTTPConnection("icanhazip.com")
    conn.request("GET", "/")
    time.sleep(3)
    response = conn.getresponse()
    print('current ip address :', response.read())

# Launch Tor and connect to Tor network
sproc = launchTor()
connectTor()

# list of url to scrape
url_list = [list of all the urls you want to scrape]

for url in url_list:
    # set new ip and check ip before scraping for each new url
    set_new_ip()
    # allow some time for IP address to refresh
    time.sleep(5)
    checkIP()

    '''
    [insert your scraping code here: bs4, urllib, your usual thingy]
    '''

# remember to kill process 
killTor(sproc)