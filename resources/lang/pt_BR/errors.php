<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Clients Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used all library to build
    | the simple page files. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    // Error 403
    '403-g'                         => '403',
    '403'                           => '403 Sem Permiss&atilde;o de acesso',
    '403-description'               => 'Oops! Parece que voc&ecirc; n&atilde;o pode visualizar essa p&aacute;gina',
    '403-info'                      => 'Voc&ecirc; não possui permiss&atilde;o para ver esta p&aacute;gina. Entretanto, voc&ecirc; pode <a href=' . URL::to('/') . '>retornar para a dashboard</a> ou tentar usar a busca abaixo.',

    // Error 404
    '404-g'                         => '404',
    '404'                           => '404 P&aacute;gina n&atilde;o encontrada',
    '404-description'               => 'Oops! P&aacute;gina n&atilde;o encontrada',
    '404-info'                      => 'N&atilde;o encontramos a p&aacute;gina que voc&ecirc; procura. Entretanto, voc&ecirc; pode <a href=' . URL::to('/') . '>retornar para a dashboard</a> ou tentar usar a busca abaixo.',

    // Error 500
    '500-g'                         => '500',
    '500'                           => '500 P&aacute;gina erro interno no servidor',
    '500-description'               => 'Oops! P&aacute;gina ocorreu um erro no servidor',
    '500-info'                      => 'Ocorreu um erro tente atualizar a p&aacute;gina em alguns instantes',

    // Error 503
    '503-g'                         => '503',
    '503'                           => '503 P&aacute;gina erro interno no servidor',
    '503-description'               => 'Oops! P&aacute;gina ocorreu um erro no servidor',
    '503-info'                      => 'Ocorreu um erro tente atualizar a p&aacute;gina em alguns instantes',
];