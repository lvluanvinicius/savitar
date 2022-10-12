# Carregando variáveis de ambiente
from conf.env import EnvConfig
EnvConfig().load_env()


from os import getenv
from sys import path
path.insert(0, "../")

# import libs
import mysql.connector

class MysqlConnection(object):

    def __init__(self):
        self.USERNAME = getenv("DB_USERNAME")
        self.PASSWORD = getenv("DB_PASSWORD")
        self.PORT = getenv("DB_PORT")
        self.HOST = getenv("DB_HOST")
        self.DATABASE = getenv("DB_DATABASE")

    def __str__(self):
        return f"Config Mysql: [Host {self.host} and port {self.port}]"

    def connection(self):
        conn = mysql.connector.connect(
            user=self.USERNAME,
            password=self.PASSWORD,
            host=self.HOST,
            port=self.PORT,
            database=self.DATABASE,
            auth_plugin='mysql_native_password'
        )

        return conn


