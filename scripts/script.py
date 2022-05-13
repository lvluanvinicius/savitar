import json


try:
    from threading import Thread; 
except Exception as err: 
    print("Múdulo threding não instalado.")
    exit()
    
try:
    import urllib3
except Exception as err: 
    print("Múdulo urllib3 não instalado.")
    exit()
    
try:
    import orjson
except Exception as err: 
    print("Múdulo orjson não instalado.")
    exit()


#####################################
# Instalação de modulos...
# python3 -m install urllib3 orjson #


urltarget = "https://api.opsgenie.com/v2"
token = "0af8ccdd-bb8b-44b0-b093-98d70d8d3fd7"


def requestData(config):
    # Configuração dos headers.
    https = urllib3.PoolManager(headers={
        "Content-Type": "application/json",
        "Authorization": f"GenieKey {token}"
    })
    
    # Request config
    response = https.request(
        method=config["method"], 
        url=config["target"]+config["path"])
    
    # Retorno da string
    return response.data.decode()



def getOffSet():
    data = orjson.loads(requestData(config={
        "method": "GET",
        "target": urltarget,
        "path": "/alerts?offset=5&limit=100&sort=createdAt&order=desc"
    }))
    
    return data["paging"]["last"].split("&")[2].split("=")[1]
    

def execute_search(config, dataTmp):
    response = orjson.loads(requestData(config=config))
    
    try: 
        cont=0
        while cont < len(response["data"]):
            dataTmp.append(response["data"][cont])
            cont+=1            
        
    except Exception as err:
        pass
    

offSet= int(getOffSet()) # Salva o total do Offset.
counter=0
dataTmp=[] # Temporário para concatenar todos os dados da requisição.

while counter <= offSet:
    
    config={
        "method": "GET",
        "target": urltarget,
        "path": f"/alerts?limit=100&sort=createdAt&offset={counter}&order=desc"
    }
                
    Thread(target=execute_search, args=(config, dataTmp)).start()
    counter+=1
    

print(orjson.loads(dataTmp))