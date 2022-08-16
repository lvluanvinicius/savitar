import sys
sys.path.insert(0, "../")

# import libs
from sql.connections import MysqlConnection


class PonsAverage(object):
    
    def __init__(self):
        self.TABLE = "pons_average_dbm"
        
    def save(self, data):
        print(data)
        sqlclass = MysqlConnection()
        conn = sqlclass.connection()
        if conn.is_connected():
            sql = f"""INSERT INTO pons_average_dbm (
                    ID_OLT, PON, DBM_AVERAGE, created_at, updated_at
                ) VALUES (
                %s, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                )"""
            cursor = conn.cursor()
            cursor.execute(sql, (data["ID_OLT"], data["PON"], data["DBM_AVERAGE"]))
            conn.commit()
            cursor.close()

        else:
            print("Error: Banco de dados não conectado.")
            exit()
