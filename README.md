## Camagru - упрощенный Instargram <br>

Проект находится в <b>РАЗРАБОТКЕ</b>
(имеются рабочие комменты с частями кода необходимыми для дебага, отладки и тд. Все это будет приведено в порядок к релизу)

<b>Серверная часть</b> - чистый PHP <br>
<b>База данных</b> - MySQL c с использованием PDO <br>
<b>Фронт</b> - HTML, CSS (Grid), JavaSript + Ajax <br>


Использую сервер PHP на MacOS - php -S localhost:51555 <br>
На ubuntu использую LAMP 

## ATTENTION! <br>
config/setup.php - создает базу данных и таблицы необходимые для сайта (поменяйте настроки под ваш сервер) <br>
config/database.php - настройки подключения

Стартовый файл - <b>index.php</b>


## РЕАЛИЗОВАНО:<br>
- Логин форма Sing in / Sing up / Reset password<br>
Все запросы происходят асинхронно с помощью Ajax + PHP + PDO:MySQL<br>
- хэширование пароля + solt<br>
- активация аккаунта по email (ссылка + хэш token)<br>
- регулярки на username, минимальный password, проверка email<br>
- защита от SQL-инъекций (prepare)<br>
- проверки на уникальность usermane, email, активацию аккаунта<br>

#### home.php - основная страница user<br>
- Веб-камера с помощью JavaScript<br>
- Временная галерея сделанных фото<br>


## СОВСЕМ СКОРО:<br>
- только залогиненные юзеры смогут иметь доступ к страницам home.php / gallery.php / options.php<br>
реализую с помощью глобки $_SESSION;<br>

#### home.php<br>
- возможность загрузить фото, скачать фото, удалить фото, выложить фото в галлерею<br>
- в хедере кнопка Logout, приветсвие, кнопку Options<br>
- в целом приведу в порядок фронт страницы (сейчас там рабочий беспорядок и анархия, чисто для отладки)<br>
- аналог масок, фильтры для камеры<br>

#### gallery.php<br>
- все фото выложенные разегистрированными пользователями<br>
- возможность лайкать фото + счетчик лайков, привет Ajax<br>
- возможность комментировать публикации, Ajax<br>
- возможность удалить публикацию для user ownera<br>

#### options.php<br>
- настройка уведомлений о лайках, комментариях, изменении данных профиля<br>
- добавление аватарки<br>
- изменение данных, username, email<br>

Полноценный <b>MVC</b> для этого проекта не стал реализовывать, еще не достаточно разобрался.<br>
Скорее всего добавлю <em>(пока не знаю как лучше реализовать и надо ли?)</em>:<br>
- добавлю директ Class куда закину все классы<br>
- добавлю директ Controller, где будет один php файл обрабатывающий все запросы<br>

<b><em>Почему не использовал jQuery для AJAX?!</b> - нельзя по условиям проекта, чистый js, должны сначала научиться на нем.<br>
А вот сетки на Bootstrap не юзал потому что понравились Gridы и хотел их опробовать на проекте.<br>

ps изначально все написал без AJAX (потому что это бонус и не обязательно), но потом понял что лайки и многие вещи..ну не серьезно без AJAX<br>
За день изучил, внедрил, работает. Пришлось все переписывать.<br>

<b>Почему именно такой функционал и почему иммено такой стэк??</b><br>
Все в соответствии с Техническим заданием ( лежит в корне папка /DescriptionScreenshots)</em><br>

И чтобы вам не искать, скрины ТЗ закреплены ниже:

![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart1.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart2_3.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart4.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart5.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/BonusPart.png)








