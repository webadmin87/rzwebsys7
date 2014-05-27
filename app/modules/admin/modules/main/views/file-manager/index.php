<?php
use mihaildev\elfinder\ElFinder;

?>

    <?
    // @TOFIX заменить файловый менеджер на более конфигурируемый
    echo ElFinder::widget([
        'language' => 'ru',
        'controller' => 'elfinder', //вставляем название контроллера по умолчанию равен elfinder
        //'filter' => 'image', //филтер файлов, можно задать масив филтров  https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'containerOptions'=>['style'=>'height: 400px;'],
    ]);
    ?>
