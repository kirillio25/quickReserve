# Настройка 

Устанавливаем зависимости
```bash
docker compose run composer install
docker compose run node npm install
```

Ключ и миграции
```bash
docker compose run artisan key:generate
docker compose run artisan migrate
```

Наполнение базы тестовыми данными
```bash
docker compose run artisan db:seed
```

Запуск
```bash
docker compose up -d
```

# Материал 
https://drive.google.com/drive/folders/1UXOdhqwgvobl9cyZc4sILr_6znG_S2r0?usp=drive_link
