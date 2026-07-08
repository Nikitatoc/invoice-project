Попередні вимоги
Docker Desktop (Docker Engine + Docker Compose)
Git
Клонування репозиторію
git clone https://github.com/Nikitatoc/invoice-project.git

cd invoice-project
Налаштування Backend

Перейдіть у папку backend і створіть файл .env на основі .env.example.

Заповніть параметри бази даних:

DB_CONNECTION=pgsql
DB_HOST=invoice_db
DB_PORT=5432
DB_DATABASE=invoice_db
DB_USERNAME=user
DB_PASSWORD=password
Запуск проєкту

Побудуйте образи та запустіть контейнери:

docker compose up -d --build

Після першого запуску виконайте міграції:

docker compose exec backend php artisan migrate
Доступ до застосунку
Frontend: http://localhost:3000
Backend API: http://localhost:8000/api
