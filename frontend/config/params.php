<?php
return [
    'adminEmail' => 'admin@example.com',
    'gender'=>[
        0=>'Ayol',
        1=>'Erkak',
    ],
    'status'=>[
        1=>'Aktiv',
        0=>'Deaktiv',
        -1=>'O`chirilgan'
    ],
    'paid.type'=>[
        '1'=>'Umumiy sotuv',
        '2'=>'Mijozga sotuv'
    ],
    'telegram'=>[
        'token'=>'7501127856:AAGehuiIx749E1FlkYeuxuDj9bX_9TKrwG4'
    ],
    'sale.state'=>[
        'NEW'=>'YANGI',
        'RUNNING'=>'TA`MIRLANMOQDA',
        'DONE'=>'YAKUNLANGAN',
        'CANCELLED'=>'BEKOR QILINGAN',
    ],
    'sale.log'=>[
        'text'=>[
            'NEW'=>'Shartnoma yaratildi',
            'RUNNING'=>'Shartnoma bo`yicha ish boshlandi',
            'UPDATED'=>'Shartnomaga o`zgartirish kiritildi',
            'COMPLETED'=>'Shartnoma bo`yicha ish bajarib bo`lindi',
            'CANCELLED'=>'Sharntoma bekor qilindi'
        ],
        'color'=>[
            'NEW'=>'#17a2b8',
            'RUNNING'=>'#ffc107',
            'UPDATED'=>'#1b00ff',
            'COMPLETED'=>'#28a745',
            'CANCELLED'=>'#dc3545'
        ]
    ],

    'layout'=>[
        'magazine'=>'Dokonlar uchun',
        'detailing'=>'Avtomoshina tamirlash',
        'forniture'=>'Mebel',
    ],
    'price_type'=>[
        'SUM'=>'So`mda keladi va sotiladi',
        'RATE'=>'Valyutada keladi va konvert qilinadi'
    ],
    'forniture_service_state'=>[
        'NEW'=>'YANGI',
        'CALC'=>'HISOBLANMOQDA',
        'RUNNING'=>'BAJARILMOQDA',
        'DONE'=>'TAYYOR',
        'COMPLETED'=>'YETKAZIB BERILDI',
        'CANCELED'=>'BEKOR QILINDI',
    ],
    'worker'=>5,

    'app'=>'detailing',
    'access_layout'=>'detailing',
    'access_service'=>'detailing',
    'permissions'=>[
        'detailing'=>[
            'default'=>[
                'all'=>true,
            ],
            'gen'=>[
                'all'=>true,
                'sale'=>true,
                'income'=>true,
                'returntosuppler'=>true,
                'credit'=>true,
            ],
            'visit'=>[
                'all'=>true,
                'list'=>true,
                'create'=>true,
                'view'=>true,
                'client-car'=>true,
            ],
            'client-car'=>[
                'all'=>true,
            ],
            'sale'=>[
                'all'=>true,
                'index'=>true,
                'credit'=>true,
                'credittoday'=>true,
                'credittodayview'=>true,
                'view'=>true,
            ],
            'paid'=>[
                'all'=>true,
            ],
            'suppler-paid'=>[
                'all'=>true,
            ],
            'paid-other'=>[
                'all'=>true,
            ],
            'come'=>[
                'all'=>true,
                'reminder'=>true,
                'view'=>true,
            ],
            'goods'=>[
                'all'=>true,
                'index'=>true,
                'view'=>true,
                'update'=>true,
                'create'=>true,
            ],
            'goods-group'=>[
                'all'=>true,
                'index'=>true,
                'view'=>true,
                'update'=>true,
                'create'=>true,
            ],
            'service'=>[
                'all'=>true,
                'index'=>true,
                'view'=>true,
                'update'=>true,
                'create'=>true,
            ],
            'service-group'=>[
                'all'=>true,
                'index'=>true,
                'view'=>true,
                'update'=>true,
                'create'=>true,
            ],
            'client'=>[
                'all'=>true,
                'index'=>true,
                'view'=>true,
                'update'=>true,
                'create'=>true,
                'credit'=>true,
                'debt'=>true,
            ],
            'client-type'=>[
                'all'=>true,
                'index'=>true,
                'view'=>true,
                'update'=>true,
                'create'=>true,
            ],
            'suppler'=>[
                'all'=>true,
                'index'=>true,
                'view'=>true,
                'update'=>true,
                'create'=>true,
                'income'=>true,
                'debt'=>true,
                'credit'=>true,
            ],
            'suppler-return'=>[
                'all'=>true,
            ],
            'user'=>[
                'all'=>true,
            ],
            'setting'=>[
                'all'=>true,
            ],
            'custom-type'=>[
                'all'=>true,
            ],
            'forniture-service'=>[
                'all'=>false,
            ],
            'forniture-service-order'=>[
                'all'=>false,
            ],
            'forniture-service-order-item'=>[
                'all'=>false,
            ],
        ],
    ],


];
