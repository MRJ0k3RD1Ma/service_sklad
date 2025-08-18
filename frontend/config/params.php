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
    'service.state'=>[
        'NEW'=>'YANGI',
        'RUNNING'=>'TA`MIRLANMOQDA',
        'COMPLETED'=>'YAKUNLANGAN',
    ],
    'access_service'=>true,
    'price_type'=>[
        'SUM'=>'So`mda keladi va sotiladi',
        'RATE'=>'Valyutada keladi va konvert qilinadi'
    ],
    'deposit.state'=>[
        'PREPARE'=>'PREPARE', 'PAY'=>'PAY', 'VERIFY'=>'VERIFY', 'CHECK'=>'CHECK', 'DONE'=>'DONE'
    ],
    'payout.state'=>[
        'NEW'=>'NEW',
        'PAYOUTED'=>'PAYOUTED',
        'CANCELED'=>'CANCELED',
    ]
];
