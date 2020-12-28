<?php
return [
    'app' => [
        'title' => 'Генерал',
        'desc' => 'Все общие настройки для сайта.',
        'icon' => 'fas fa-home',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'app_name', // unique name for field
                'label' => 'Название сайта', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'E-book' // default value if you want
            ]
        ]
    ],
    'email' => [
        'title' => 'Email',
        'desc' => 'Настройки электронной почты для сайта',
        'icon' => 'fas fa-envelope',

        'elements' => [
            [
                'type' => 'email',
                'data' => 'string',
                'name' => 'admin_email',
                'label' => 'Электронная почта администратора',
                'rules' => 'required',
                'class' => '',
                'value' => 'admin@gmail.com'
            ],
        ]
    ],
    'location' => [

        'title' => 'Гео Расположение',
        'desc' => 'Настройки местоположения для сайта',
        'icon' => 'fas fa-map-pin',

        'elements' => [
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'shop_lat',
                'label' => 'Широта магазина',
                'rules' => 'required',
                'class' => '',
                'value' => '41.318528'
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'shop_lng',
                'label' => 'Долгота магазина',
                'rules' => 'required',
                'class' => '',
                'value' => '69.244890'
            ],
        ]
    ],
    'delivery' => [
        'title' => 'Доставка',
        'desc' => 'Настройка доставки с сайта',
        'icon' => 'fas fa-truck',

        'elements' => [
            [
                'type' => 'number',
                'data' => 'float',
                'name' => 'delivery_price',
                'label' => 'Стоимость доставки',
                'rules' => 'required',
                'class' => '',
                'value' => 10000
            ],
        ]
    ],
]
?>
