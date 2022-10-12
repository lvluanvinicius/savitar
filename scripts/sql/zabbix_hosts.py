# Carregando variáveis de ambiente
from os import getenv
from conf.env import EnvConfig
EnvConfig().load_env()

# import libs
from sql.connections import MysqlConnection


class ZabbixHosts(object):

    def __init__(self):
        self.TABLE = "hosts_zbx"


    def save(self, data):
        sqlclass = MysqlConnection()
        conn = sqlclass.connection()
        if conn.is_connected():
            sql = f"""INSERT INTO {self.TABLE} (
                    hostid, name, host, status
                ) VALUES (
                    %s, %s, %s, %s
                )"""
            cursor = conn.cursor()
            cursor.execute(sql, (data["hostid"], data["name"], data["host"], data["status"]))
            conn.commit()
            cursor.close()

        else:
            print("Error: Banco de dados não conectado.")
            exit()

    def get_hosts_ids(self):
        sqlclass = MysqlConnection()
        conn = sqlclass.connection()
        if conn.is_connected():
            sql = f"""SELECT hostid FROM {self.TABLE}"""
            cursor = conn.cursor(dictionary=True, buffered=True)
            cursor.execute(sql)
            consult = cursor.fetchall()
            cursor.close()
            conn.close()
            return consult

        else:
            return "Error: Banco de dados não conectado."
