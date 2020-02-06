# CAMAGRU-INSTAGRAM
Camagru - упрощенный Instargram

Проект находится в РАЗРАБОТКЕ 
(имеются рабочие комменты с частями кода необходимыми для дебага, отладки и тд. <br> Все это будет приведено в порядок к релизу)

Серверная часть - чистый PHP <br>
База данных - MySQL c с использованием PDO <br>
Фронт - HTML, CSS (Grid), JavaSript + Ajax <br>


Использую сервер PHP на MacOS - php -S localhost:51555 <br>
На ubuntu использую LAMP 

<b>ATTENTION!<b> <br>
config/setup.php - создает базу данных и таблицы необходимые для сайта (поменяйте настроки под ваш сервер) <br>
config/database.php - настройки подключения

Стартовый файл - index.php


РЕАЛИЗОВАНО:
- Логин форма Sing in / Sing up / Reset password
Все запросы происходят асинхронно с помощью Ajax + PHP + PDO:MySQL
- хэширование пароля + solt
- активация аккаунта по email (ссылка + хэш token)
- регулярки на username, минимальный password, проверка email
- защита от SQL-инъекций (prepare)
- проверки на уникальность usermane, email, активацию аккаунта

home.php - основная страница user
- Веб-камера с помощью JavaScript
- Временная галерея сделанных фото


СОВСЕМ СКОРО:
- только залогиненные юзеры смогут иметь доступ к страницам home.php / gallery.php / options.php
реализую с помощью глобки $_SESSION;

home.php
- возможность загрузить фото, скачать фото, удалить фото, выложить фото в галлерею
- в хедере кнопка Logout, приветсвие, кнопку Options
- в целом приведу в порядок фронт страницы (сейчас там рабочий беспорядок и анархия, чисто для отладки)
- аналог масок, фильтры для камеры

gallery.php
- все фото выложенные разегистрированными пользователями
- возможность лайкать фото + счетчик лайков, привет Ajax
- возможность комментировать публикации, Ajax
- возможность удалить публикацию для user ownera

options.php
- настройка уведомлений о лайках, комментариях, изменении данных профиля
- добавление аватарки
- изменение данных, username, email

Полноценный MVC для этого проекта не стал реализовывать, еще не достаточно разобрался.
Скорее всего добавлю (пока не знаю как лучше реализовать и надо ли?):
- добавлю директ Class куда закину все классы
- добавлю директ Controller, где будет один php файл обрабатывающий все запросы

Почему не использовал jQuery для AJAX?! - нельзя по условиям проекта, чистый js, должны сначала научиться на нем.
А вот сетки на Bootstrap не юзал потому что понравились Gridы и хотел их опробовать на проекте

ps изначально все написал без AJAX (потому что это бонус и не обязательно), но потом понял что лайки и многие вещи..ну не серьезно без AJAX
За день изучил, внедрил, работает. Пришлось все переписывать.

Почему именно такой функционал и почему иммено такой стэк??
Все в соответствии с Техническим заданием ( лежит в корне папка /DescriptionScreenshots)

И чтобы вам не искать, скрины ТЗ закреплены ниже:

![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart1.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart2_3.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart4.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart5.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/BonusPart.png)








