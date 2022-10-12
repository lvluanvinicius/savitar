# Carregando variáveis de ambiente
from sql.zabbix_items import ZabbixItems
from sql.zabbix_hosts import ZabbixHosts
from sys import argv
from pyzabbix.api import ZabbixAPI
from os import getenv
from conf.env import EnvConfig
EnvConfig().load_env()


# Create ZabbixAPI class instance
zapi = ZabbixAPI(url='https://zabbix.cednet.com.br/',
                 user=getenv("ZABBIX_USERNAME"), password=getenv("ZABBIX_PASSWORD"))


zbx_hosts = ZabbixHosts()
zbx_items = ZabbixItems()

if argv[1] == "save-host":
    # Get all disabled hosts
    result2 = zapi.do_request(
        'host.get', {'filter': {'status': 1}, 'output': [
            "hostid", "name", "host", "status",
        ]})

    # Logout from Zabbix
    zapi.user.logout()

    for r in result2["result"]:
        zbx_hosts.save(data=r)

    zapi.user.logout()


elif argv[1] == "save-items":

    for hs in zbx_hosts.get_hosts_ids():
        # Get Items
        result2 = zapi.do_request(
            'item.get', {'output': ['itemid', 'name', 'hostid', 'description', 'value_type'], "hostids": hs["hostid"]})

        for r in result2["result"]:
            zbx_items.save(r)

    # Logout from Zabbix
    zapi.user.logout()


elif argv[1] == "save-hist":
    for it in zbx_items.get_items_ids():
        # Get Histories. 971369007
        result2 = zapi.do_request(
            'history.get', {'output': 'extends', "itemids": it["itemid"]})

        for i in result2["result"]:
            print(i)

        break

    zapi.user.logout()

else:
    print("Informe uma ação")
