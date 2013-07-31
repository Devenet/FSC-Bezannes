# FSC Bezannes

Source code of the FSC Bezannes webapplication


***

__Version__ : RC1


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

Just add a JSON file called `configuration.json` in `config/` folder with these information:

    ```json
    {
      "year": "2012",
      "phone": "0326000000",
      "email": "contact@fsc.local",
      "search_engine": "false",
      "fsc": "//fsc.local",
      "gestion": "//gestion.fsc.local",
      "preinscription": "//preinscriptions.fsc.local",
      "analytics_fsc": false,
      "analytics_gestion": false,
      "analytics_preinscription": false,
      "path_uploads_full": "public/uploads",
      "static": "//fsc.local",
      "uploads": "//fsc.local/uploads"
    }
    ```
