# Установка 
docker compose run --rm composer install
docker compose run --rm artisan key:generate
docker compose run --rm artisan migrate
docker compose run --rm node npm install

# Наполнение базы тестовыми данными
docker compose run --rm artisan db:seed

# Материал 
https://drive.google.com/drive/folders/1UXOdhqwgvobl9cyZc4sILr_6znG_S2r0?usp=drive_link
