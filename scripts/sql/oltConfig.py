
import sys
sys.path.insert(0, "../")

# import libs
from sql.connections import MysqlConnection


class OltConfig(object):

    def __init__(self):
        self.TABLE = "olt_config"

    def get_olt_config(self):
        sqlclass = MysqlConnection()
        conn = sqlclass.connection()
        if conn.is_connected():
            sql = f"""SELECT * FROM {self.TABLE}"""
            cursor = conn.cursor(dictionary=True, buffered=True)
            cursor.execute(sql)
            consult = cursor.fetchall()
            cursor.close()
            conn.close()
            return consult

        else:
            return "Error: Banco de dados não conectado."


