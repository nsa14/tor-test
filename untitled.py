#!/usr/bin/env python3

import requests
from stem.control import Controller, Signal
import time
import sys
import re

# specify Tor's SOCKS proxy for http and https requests
proxies = {
    'http': 'socks5h://127.0.0.1:9150',
    'https': 'socks5h://127.0.0.1:9150',
}

try:
    controller = Controller.from_port(9150) # try to connect to controller at localhost:9150
except stem.SocketError as exc:
    print("Unable to connect to tor on port 9150: %s" % exc)
    sys.exit(1)

try:
    controller.authenticate('password') # try to authenticate with password "password"
except stem.connection.PasswordAuthFailed:
    print("Unable to authenticate, password is incorrect")
    sys.exit(1)

# issue 10 requests, changing identity after each request
for i in range(1,10):
    # issue request, passing proxies to request
    r = requests.get('https://drew-phillips.com/ip-info/', proxies=proxies)

    #print(r.text)

    m = re.search('<dt>Using Tor:</dt><dd><span[^>]*>Yes', r.text)
    if m:
        print("You appear to be using Tor successfully.  ", end="")
    else:
        print("Proxy worked but this Tor IP is not known.  ", end="")

    m = re.search('<dt>IP Address:</dt><dd>(\d+\.\d+\.\d+\.\d+)</dd>', r.text)
    if m:
        print("Source IP = %s" % m.groups(1))
    else:
        print("Failed to scrape IP from page")

    try:
        # send signal to controller to request new identity (IP)
        controller.signal(Signal.NEWNYM)
    except Exception as ex:
        print("NEWNYM failed: %s" % ex)

    time.sleep(10)
    
