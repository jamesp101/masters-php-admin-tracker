while inotifywait -r -e modify,create,delete,move nginx/; do
    rsync -rv /home/james/projects/nginx/ /var/www/html/masters
done
