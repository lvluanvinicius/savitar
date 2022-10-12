# Carregando variáveis de ambiente
from os import getenv
from conf.env import EnvConfig
EnvConfig().load_env()

# import libs
from sql.connections import MysqlConnection


class ZabbixItems(object):

    def __init__(self):
        self.TABLE = "items_zbx"


    def save(self, data):
        try:
            sqlclass = MysqlConnection()
            conn = sqlclass.connection()
            if conn.is_connected():
                sql = f"""INSERT INTO {self.TABLE} (
                        itemid, name, hid, description, value_type
                    ) VALUES (
                        %s, %s, %s, %s, %s
                    )"""
                cursor = conn.cursor()
                cursor.execute(sql, (data["itemid"], data["name"], data["hostid"], data["description"], data["value_type"]))
                conn.commit()
                cursor.close()

        except Exception as error:
            pass

        else:
            print("Error: Banco de dados não conectado.")
            exit()

    def get_items_ids(self):
        sqlclass = MysqlConnection()
        conn = sqlclass.connection()
        if conn.is_connected():
            sql = f"""SELECT itemid FROM {self.TABLE}"""
            cursor = conn.cursor(dictionary=True, buffered=True)
            cursor.execute(sql)
            consult = cursor.fetchall()
            cursor.close()
            conn.close()
            return consult

        else:
            return "Error: Banco de dados não conectado."
