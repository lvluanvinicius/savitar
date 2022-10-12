from os.path import join, dirname
from sys import path
from dotenv import load_dotenv
from time import sleep
path.insert(0, ".")

class EnvConfig(object):

    def __init__(self):
        pass


    def load_env(self):
        dotenv_path = join(dirname(__file__), '../../.env')
        load_dotenv(dotenv_path)
