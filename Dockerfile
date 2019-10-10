# Author: Jordan Mercier, Maximilian Vogel
# Date: 09.10.2019
# Description: Dockerfile to copy the files of the web application

FROM arubinst/sti:project2018

COPY site/ /usr/share/nginx/