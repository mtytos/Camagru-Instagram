## Camagru - упрощенный Instargram <br>

Проект находится в <b>РАЗРАБОТКЕ</b>
(имеются рабочие комменты с частями кода необходимыми для дебага, отладки и тд. Все это будет приведено в порядок к релизу)

- <b>Серверная часть</b> - PHP <br>
- <b>База данных</b> - MySQL + PDO <br>
- <b>Фронт</b> - HTML, CSS (Grid), JavaSript + Ajax <br>

## ATTENTION! <br>
- <em>config/database.php</em> - настройки подключения к БД <br>
- <em>config/setup.php</em> - создает базу данных и таблицы необходимые для сайта <br>
также будет автоматически создан user - admin / admin для быстроего использования сайта </br>

## РЕАЛИЗОВАНО:<br>
#### Sing In / Sing Up<br>
- защита от SQL-инъекций (prepare)<br>
- защита от XSS <br>
- хэширование пароля + solt<br>
- активация аккаунта по email (ссылка + хэш token)<br>
- регулярки на username, минимальный password, проверка email<br>
- запросы Ajax <br>

#### Home<br>
- Веб-камера с помощью JavaScript<br>
- Временная галерея сделанных фото<br>


## СОВСЕМ СКОРО:<br>
- только залогиненные юзеры смогут иметь доступ к страницам home.php / gallery.php / options.php<br>
(реализую с помощью глобалки $_SESSION)<br>

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
- добавлю диркторию img: <br> 
когда пользователь запостит фото будет создана папка с его username и добавлено фото<br>
имя фото это $username . '.' . number = ищу максимальный id_pic в таблице c фото, добавляю +1<br>

#### options.php<br>
- настройка уведомлений о лайках, комментариях, изменении данных профиля<br>
- добавление аватарки<br>
- изменение данных, username, email<br>

Полноценный <b>MVC</b> для этого проекта не стал реализовывать, еще не достаточно разобрался.<br>
Скорее всего добавлю <em>(пока не знаю как лучше реализовать и надо ли?)</em>:<br>
- добавлю директ Class куда закину все классы<br>
- добавлю директ Controller, где будет один php файл обрабатывающий все запросы<br>

<b><em>Почему не использовал jQuery для AJAX?!</b> - нельзя по условиям проекта, только чистый js, должны сначала научиться на нем.<br>
  А вот сетки на <b>Bootstrap</b> не юзал потому что понравились <b>Grid</b>ы и хотел их опробовать на проекте.<br>

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








