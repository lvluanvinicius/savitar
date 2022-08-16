import sys
sys.path.insert(0, "../")

# import libs
import mysql.connector

class MysqlConnection(object):

    def __init__(self):
        self.USERNAME = "root"
        self.PASSWORD = "965700"
        self.PORT = "33061"
        self.HOST = "10.254.192.212"
        self.DATABASE = "api_report"

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


