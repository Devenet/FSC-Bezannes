# FSC Bezannes

Source code of the FSC Bezannes webapplication


***

__Version__ : See [`version.json`](https://github.com/nicolabricot/FSC-Bezannes/blob/master/config/version.json) file


## Database configuration

Just add a JSON file called `database.json` in `config/`  folder with these informations:

```json
{
  "dsn": "mysql:localhost;dbname=fsc",
  "login": "fsc",
  "password": "fsc"
}
```

## Application configuration

### General settings

Add a JSON file called `settings.json` in `config/` folder with these information:

```json
{
  "year": 2013,
  "phone": "0326000000",
  "email": "contact@fsc.local",
  "search_engine": false,
  "fsc": "//fsc.local",
  "gestion": "//gestion.fsc.local",
  "preinscription": "//preinscriptions.fsc.local",
  "preinscription_enabled": true,
  "analytics_fsc": false,
  "analytics_gestion": false,
  "analytics_preinscription": false,
  "static": "//static.fsc.local",
  "uploads": "//static.fsc.local/uploads"
}
```
### Prices

Add a JSON file called `prices.json` in `config/` folder with these information:

```json
{
  "adult": [
    21,
    17
  ],
  "teen": [
    15,
    11
  ]
}
```

_First price is for external people, second price is for local people._

