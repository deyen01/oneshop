Настройка для систем Debian, Ubuntu.

Перейдите в каталог Ваших сайтов, по умолчанию это:
/var/www

Выполните команду:
git clone https://github.com/deyen01/oneshop.git
Разместите проект в нужной папке в соответстивии с настройками Вашего веб-сервера

Образец настройки виртуального хоста для Apache2:

<VirtualHost *:80>
        ServerName your_domain
        DocumentRoot /var/www/oneshop/public
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

Где oneshop - название папки, где расположен проект.

Проконтролируйте, чтобы пользователь от имени которого выполняется веб-сервер (обычно это www-data),
обладал правами на запись в папку storage, а также его подпапки и файлы.

Создайте базу данных в MySQL или MariaDB и укажите настройки подключения в файле .env

Замените в файле .env your_domain на Ваш домен.
Вы также можете указать локальный домен, записаный в файле /etc/hosts.

В папке проекта, обновите зависимости:
composer update
npm install
npm run dev

Сформируте новый ключ приложения:

php artisan key:generate

Выполните миграции и наполнение базы данных тестовыми данными:

php artisan migrate:fresh --seed

Перейдите в браузер и откройте приложение.
