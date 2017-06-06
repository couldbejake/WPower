# Import all the needed libraries
from time import gmtime, strftime, time
import os.path as op
import os
import time as sleep

# Request the current day as a number and hour.
current_day_hour = strftime("%u:%H")

def getState(_file, _lightid):
  for line in _file:
    if(line.split(":")[1].replace(" ","").replace("\n","") == "0"):
      return False
    else:
      return True

# Print the day:hour for Debug
print("Current TimeDay "+str(current_day_hour))

# Print the lights current state
state_f = open('/var/www/pin_values', 'r')

lights_on = {'1':1, '2':3, '3':5, '4':7}
lights_off = {'1':2, '2':4, '3':6, '4':8}

schedule_off = [1]

for light_id_i in range(1,5):
  if( not (light_id_i in schedule_off)):
    light_id = str(light_id_i)
    print(getState(state_f, light_id))
    # Set the lights off variable to True
    light_off = True
    print("Opening Schedule Data")
    # Open the schedule Data
    schedule_data = open('/var/www/html/scheduledata'+light_id+'.txt','r')
    # For every instance of schedule data if the current time =
    # schedule data, set the lights to on. If there is no
    # schedule data, set the lights to off.
    for line in schedule_data:
      for position in line.split(","):
        if(position == current_day_hour):
           print("~ Light "+light_id+" Has been scheduled. ~\n")
           print("Switching on Light "+light_id+".\n")
           # Call the relay_handler script
           os.system("python /var/www/relay_handler.py "+str(lights_on[light_id])+" Scheduler")
           light_off = False

    if(light_off):
      # Call the relay_handler script
      os.system("python /var/www/relay_handler.py "+str(lights_off[light_id])+" Scheduler")

