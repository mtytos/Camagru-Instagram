<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Options</title>
    <link href="../style/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="header">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="content">
        <div class="main">
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления о лайках ваших постов</p>
                <button type="submit" name="action" value="like">
                    <?php
                    require_once '../core/OptionClass.php';
                    $act = new Options;
                    if ($act->likeInfo() == 1) {
                        echo 'Turn off';
                    }
                    else {
                        echo 'Turn on';
                    } ?>
                </button>
            </form>
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления о комментариях ваших постов</p>
                <button type="submit" name="action" value="comment">
                    <?php
                    require_once '../core/OptionClass.php';
                    $act = new Options;
                    if ($act->commentInfo() == 1) {
                        echo 'Turn off';
                    }
                    else {
                        echo 'Turn on';
                    } ?>
                </button>
            </form>
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления об изменениях данных профиля</p>
                <button type="submit" name="action" value="profile">
                    <?php
                    require_once '../core/OptionClass.php';
                    $act = new Options;
                    if ($act->profileInfo() == 1) {
                        echo 'Turn off';
                    }
                    else {
                        echo 'Turn on';
                    } ?>
                </button>
            </form>
            <button><a class="link-btn" href='reset.php'>Изменить пароль</a></button>
            <br/>
            <button><a class="link-btn" href='#'>Изменить имя профиля</a></button>
            <br/>
            <button><a class="link-btn" href='#'>Изменить почтовый адрес аккаунта</a></button>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
<script src="../script/optionsAjax.js"></script>
</body>
</html>