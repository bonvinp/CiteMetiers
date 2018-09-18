#!/usr/bin/env python3
# -*- coding: UTF-8 -*-# enable debugging
import cgitb
import random

cgitb.enable()

words = ['VGA', 'HDMI', 'USB', 'DVI', 'DisplayPort']
rndWords = random.sample(set(words), 3)

print("Content-Type: text/html;charset=utf-8")
print()
print(' '.join(rndWords))
