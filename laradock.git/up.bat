SET packs=nginx postgres pgadmin mailhog redis
IF [%1] EQU [build] (docker-compose up -d --build %packs%) ELSE (docker-compose up -d %packs%)