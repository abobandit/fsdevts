<?php

return [

    'required' => 'Поле :attribute обязательно для заполнения.',
    'string' => 'Поле :attribute должно быть строкой.',
    'numeric' => 'Поле :attribute должно быть числом.',
    'min' => [
        'numeric' => 'Поле :attribute должно быть не меньше :min.',
        'string' => 'Поле :attribute должно содержать минимум :min символов.',
    ],
    'exists' => 'Выбранное значение для поля :attribute некорректно.',

    'attributes' => [
        'name' => 'название',
        'description' => 'описание',
        'price' => 'цена',
        'category_id' => 'категория',
        'email' => 'email',
        'password' => 'пароль',
    ],

];
