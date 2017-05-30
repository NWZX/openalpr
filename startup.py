#!/usr/bin/python

import time
import subprocess


def main():
    subprocess.Popen(["service", "apache2", "start"])
    while True:
        output = subprocess.Popen(["service", "apache2", "status"], stdout=subprocess.PIPE)
        (sout, serr) = output.communicate()
        if sout.find("apache2 is running") != -1:
            break
    time.sleep(1000)


if __name__ == "__main__":
   main()
