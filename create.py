import xmlrpclib

username = 'admin'  #the user
pwd = 'admin'       #the password of the user
dbname = 'db_demo'  #the database

# Get the uid
sock_common = xmlrpclib.ServerProxy ('http://127.0.0.1:40069/xmlrpc/common')
uid = sock_common.login(dbname, username, pwd)

#replace 127.0.0.1 with the address of the server
sock = xmlrpclib.ServerProxy('http://127.0.0.1:40069/xmlrpc/object')

partner = {
'name': 'Fabi Pinckaers',
'lang': 'en_US', # among: en_US, en_UK, fr, ...
}

partner_id = sock.execute(dbname, uid, pwd,
                          'res.partner',
                          'create',
                          partner)

