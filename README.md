## Camagru - упрощенный Instargram <br>

- <b>Серверная часть</b> - PHP <br>
- <b>База данных</b> - MySQL + PDO <br>
- <b>Фронт</b> - HTML, CSS (Grid), JavaSript + Ajax <br>

## Настройка БД  <br>
- <em>config/database.php</em> - настройки подключения к БД. Открываете в редакторе и добавляете ваши настройки<br>
- <em>config/setup.php</em> - Запускаете в браузере. Автоматическое создание необходимого окружения <br>
также будет создан user - admin / admin для быстрого использования сайта </br>

## РЕАЛИЗОВАНО:<br>
#### Sing In / Sing Up<br>
- защита от SQL-инъекций (prepare)<br>
- защита от XSS <br>
- хэширование пароля + solt<br>
- активация аккаунта по email (ссылка + хэш token)<br>
- регулярки на username, минимальный password, проверка email<br>
- запросы Ajax <br>

#### Home<br>
- Фото с веб-камеры
- Лента с предпросмотром получившихся снимков 
- Стикеры к фото на выбор
- Возможность загрузки своего изображения
- добавление фото в галерею
- только залогиненные юзеры имеют доступ к home
- Сделать фото с веб-камеры / загрузить свое фото можно только после выбора стикера (условие по ТЗ)

#### Options<br>
- Включение / отключение уведомлений о лайках, комментариях, изменении данных профиля<br>
- Изменение имени, email, пароля пользователя<br>

#### Gallery<br>
- Посты с датой публикации<br>
- Лайки постов<br>
- Комментарии к постам с username<br>
- Владелец может удалить пост / комментарии<br>
- Галерея доступна незарегистрированным пользователем в режиме просмотра без возможности взаимодействия

- logout с основных страниц

<b>Почему именно такой функционал и почему иммено такой стэк?</b><br>
Все в соответствии с Техническим заданием ( лежит в корне папка /DescriptionScreenshots)</em><br>

И чтобы вам не искать, скрины ТЗ закреплены ниже:

![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart1.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart2_3.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart4.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/MandatoryPart5.png)
![Image alt](https://github.com/mtytos/CAMAGRU-INSTAGRAM/raw/master/DescriptionScreenshots/BonusPart.png)








