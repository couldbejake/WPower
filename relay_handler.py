#!usr/bin/python

# Import libraries
import os, sys, time, json
import RPi.GPIO as GPIO
import shutil

def addJson(_pin, _value, _time, _light_user):
  data_fname = "/var/www/data"+str(_pin)+".json"
  if(not os.path.exists(data_fname)):
    no_file =  open(data_fname, "w")
    no_file.write("[]")
    no_file.close()

  print(_time)
  if(_time == 0 or _time == "0\n" or _time == "0"):
    return True

  curr_json = []

  with open(data_fname, "r") as curr:
    curr_json = json.load(curr)
  
  data = {
    "ontime" : int(_time.split(".")[0]),
    "offtime" : round(time.time()),
    "user" : _light_user.replace("\n","")
  }  

  curr_json.append(data)

  f = open(data_fname, 'w')
  json.dump(curr_json, f)
  f.close()
  print(curr_json)

def setValue(file_name, pin, value, light_user):
    print 'Debug: Function Sucessfully called'
    if(not os.path.exists(file_name)):
       f = open(file_name,'w')
       f.write("1:0\n2:0\n3:0\n4:0")
       f.close()
   # Delete old tmp- files
    if os.path.exists(file_name+"-tmp"):
        print 'Debug: TMP file found, deleting.'
        # delete_file
        os.remove(file_name+"-tmp")
   # Open the file containing lights
    f = open(file_name, 'r')
   # Open the tmp- file
    f2 = open(file_name+"-tmp", 'w')
   # For every line in current lights
    for i in f:
      # If the first part of light_id:value ==  pin
        if i.split(':')[0] == str(pin):
          # Print found for debug
            print 'Debug: Replacing new pin value.'
          # Write the new value for pin
          # f2.write(str(pin) + ':' + str(value) + '\n')
          # print("Editing "+str(pin) + ':' + str(value))
            if(value == 1):
                f2.write(str(pin) + ':' + str(time.time()) +':'+light_user+'\n')
            else:
                if(i.count(":")==2):
		  addJson(pin, value, i.split(":")[1], i.split(":")[2])
                else:
                  addJson(pin, value, i.split(":")[1], "System")
                f2.write(str(pin) + ':' + str(0) + '\n')
        else:
          # else just write what's in the file currently
            print 'Saving ' + str(i)
            f2.write(i)# + '\n') # No new line because it already has one
   # Close both files.
    print 'Closing both files'
    f.close()
    f2.close()
    os.remove(file_name)
    shutil.copy2(file_name+"-tmp", file_name)
    os.remove(file_name+"-tmp")
   # Return true when success
    return True

# Set warnings to false to make debugging easier.
GPIO.setwarnings(False)

# Set GPIO numbers to the ones shown on the board.
GPIO.setmode(GPIO.BCM)

# Define each PIN being used to control relays.
# Pins are numbered 1-8
pins = {1 : 23, 2 : 24, 3 : 25, 4 : 22, 5 : 17, 6 : 4, 7:7, 8 : 8}

# Get the switched on PIN as an integer
pin_unformatted = int(sys.argv[1])

try:
  user_name = sys.argv[2]
except IndexError:
  user_name = "System"

print("User: "+user_name)

# Get the relating board pin.
pin = pins[pin_unformatted]

# Get the pin's group.
# Group 1 (1-2) Group 2 (3-4) GROUP 3 (5-6) GROUP 4 (7-8)
pin_data = {1:1,2:1,3:2,4:2,5:3,6:3,7:4,8:4}[pin_unformatted]

# Print the PIN number for debugging.
print(str(pin_data))

if(pin_unformatted % 2 == 0):
    setValue('/var/www/pin_values', pin_data, 0, user_name)
else:
    setValue('/var/www/pin_values', pin_data, 1, user_name)

# Set the specified PIN to output a signal
GPIO.setup(pin, GPIO.OUT)

# Give the GPIO pin time to settle
time.sleep(0.2)

# Enable the PIN
GPIO.output(pin, GPIO.LOW)

# Allow time for the relay to register
time.sleep(0.4) # 0.1

# Disable the pin
GPIO.output(pin,GPIO.HIGH)
