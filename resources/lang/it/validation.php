<?php
return [
    'required' => 'Il campo :attribute è obbligatorio.',
    'email' => 'Il campo email deve essere un indirizzo email valido.',
    'confirmed' => 'La conferma di :attribute non corrisponde.',
    'min' => [
        'string' => 'Il campo :attribute deve contenere almeno :min caratteri.',
    ],
    // ...altre regole...
    'attributes' => [
        'email' => 'email',
        'password' => 'password',
        'password_confirmation' => 'conferma password',
    ],
];