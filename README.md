📦 Product Catalog (Laravel + Inertia + Vue)

Веб-приложение: каталог товаров с административной панелью.
Backend: Laravel 12 (API + Inertia)
Frontend: Vue 3 + Inertia + Element Plus + Tailwind + Docker
DB: PostgreSQL
Auth: Laravel Sanctum

🚀 Стек
Laravel 12
Vue 3 (Composition API)
Inertia.js
Vite
PostgreSQL
Laravel Sanctum
Element Plus
Tailwind CSS
📁 Установка проекта
1. Клонировать проект
git clone <repo-url>
cd fsdevts
2. Установить зависимости backend
composer install
3. Установить зависимости frontend
npm install
4. Настроить .env
cp .env.example .env
Пример настроек DB:
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=fsdevts
DB_USERNAME=postgres
DB_PASSWORD=postgres
5. Сгенерировать ключ
php artisan key:generate
6. Запустить миграции
php artisan migrate --seed
7. Запуск проекта
Backend:
php artisan serve
Frontend (Vite):
npm run dev
🐳 Docker (если используется)
Запуск контейнеров

docker compose up -d --build

Миграции внутри контейнера

docker exec -it app php artisan migrate --seed

Node внутри контейнера (если нужно)

docker exec -it app npm install

docker exec -it app npm run dev

🔐 Авторизация
Login endpoint:
POST /api/login
Logout:
POST /api/logout
Auth (Sanctum):
GET /api/user
📦 API
Products
GET /api/products — список (пагинация)
GET /api/products/{id} — товар
POST /api/products — создать (auth)
PUT /api/products/{id} — обновить (auth)
DELETE /api/products/{id} — удалить (auth)
Categories
GET /api/categories
🧠 Функционал
Публичная часть
список товаров
фильтрация по категории
карточка товара
пагинация
Админка
CRUD товаров
создание / редактирование / удаление
защита через auth
logout
🖥 Frontend структура
resources/js/
├── Pages/
│   ├── Products/
│   ├── Admin/
│   ├── Auth/
├── Components/
├── Composables/
├── Layouts/
🔥 Особенности реализации
Composition API
Axios instance с token interceptor
Inertia shared auth props
soft delete товаров
pagination API Laravel
Element Plus UI

Laravel server
http://127.0.0.1:8000
