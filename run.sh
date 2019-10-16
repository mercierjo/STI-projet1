# Author: Jordan Mercier, Maximilian Vogel
# Date: 09.10.2019
# Description: Start the container with all the services

#!/bin/bash

chown $USER site/
chmod 777 -R site/
docker build . -t mercierj/sti:project2019
docker run --rm -ti -d -p 8080:80 --name sti_project --hostname sti mercierj/sti:project2019
docker exec -u root sti_project service nginx start
docker exec -u root sti_project service php5-fpm start
