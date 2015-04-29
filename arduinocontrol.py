import serial
import time
import urllib, urllib2
from BeautifulSoup import BeautifulSoup
print("opening serial port")
arduino= serial.Serial('/dev/ttyACM1',9600,timeout=1);
time.sleep(2)
print("INTIALIZE Completed")
l=range(10)
url = 'http://localhost/rfid.php'
while 1:
        l=arduino.read(10)
        if l:
            print(l)
            data = urllib.urlencode({'tag':l,'submit':'submit'})
            req = urllib2.Request(url, data)
            response = urllib2.urlopen(req)
            the_page = response.read()
            print the_page
            arduino.write(the_page)
