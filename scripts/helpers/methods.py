from datetime import datetime
from time import mktime


# Formatação e retorno de data e hora atribuídos no nome de arquivo de backup.
#
# fileName = {type string}
# @return 2022-01-01 10:00:02
def get_date_in_file(fileName):
    # Gerando data e hora de coleta.
    data = f"{fileName.split('-')[1][:4]}-{fileName.split('-')[1][4:6]}-{fileName.split('-')[1][6:8]} {fileName.split('-')[2].split('_')[0][0:2]}:{fileName.split('-')[2].split('_')[0][2:4]}:{fileName.split('-')[2].split('_')[0][4:6]}"
    data2 = datetime.strptime(data, '%Y-%m-%d %H:%M:%S')

    return (mktime(data2.timetuple()))
