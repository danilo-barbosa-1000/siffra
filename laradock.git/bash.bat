SET user_used=%2
IF [%user_used%] EQU [] (SET user_used=root)
docker-compose exec --user=%user_used% %1 bash