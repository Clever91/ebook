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
                'data' => 'float',
                'name' => 'shop_lat',
                'label' => 'Широта магазина',
                'rules' => 'required',
                'class' => '',
                'value' => '41.318528'
            ],
            [
                'type' => 'text',
                'data' => 'float',
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
            [
                'type' => 'number',
                'data' => 'float',
                'name' => 'min_distance_for_cash',
                'label' => 'Мин. Расстояние для наличных [m]',
                'rules' => 'required',
                'class' => '',
                'value' => 10000
            ],
            [
                'type' => 'number',
                'data' => 'float',
                'name' => 'delivery_nds',
                'label' => 'НДС (%)',
                'rules' => 'required',
                'class' => '',
                'value' => 15
            ],
        ]
    ],
    'payment' => [
        'title' => 'Онлайн платеж',
        'desc' => 'Настройка параметров оплаты',
        'icon' => 'fas fa-credit-card',

        'elements' => [
            [
                'type' => 'checkbox',
                'data' => 'string',
                'name' => 'payme',
                'label' => 'Payme',
                'rules' => '',
                'class' => '',
                'value' => "on"
            ],
            [
                'type' => 'checkbox',
                'data' => 'string',
                'name' => 'click',
                'label' => 'Click Evolution',
                'rules' => '',
                'class' => '',
                'value' => "on"
            ],
            [
                'type' => 'checkbox',
                'data' => 'string',
                'name' => 'telegram',
                'label' => 'Telegram',
                'rules' => '',
                'class' => '',
                'value' => "on"
            ],
        ]
    ],
    'group' => [
        'title' => 'Группа заказов',
        'desc' => 'Настройка группы заказов',
        'icon' => 'fas fa-users',

        'elements' => [
            [
                'type' => 'text',
                'data' => 'float',
                'name' => 'order_group',
                'label' => 'Группа ID',
                'rules' => 'required',
                'class' => '',
                'value' => '-336591551'
            ],
        ]
    ],
    'publish' => [
        'title' => 'Опубликовать сообщение',
        'desc' => 'Нижний колонтитул публикации сообщения',
        'icon' => 'fas fa-comment-medical',

        'elements' => [
            [
                'type' => 'textarea',
                'data' => 'string',
                'name' => 'post_footer',
                'label' => 'Сообщение нижнего колонтитула',
                'rules' => 'required',
                'class' => '',
                'value' => "Мурожаат учун:
📞 +99871 244 45 45
✉️ bookmedianashr@gmail.com

[Instagram](https://www.instagram.com/bookmarket24.uz/) | [Facebook](https://www.facebook.com/bookmarket24) | [Telegram](https://t.me/bookmarket24)"
            ],
        ]
    ],
]
?>
