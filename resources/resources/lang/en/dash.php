<?php
return [

    'main' => [
        'user' => [
            'text' => ' users'
        ],
        'role' => [
            'text' => ' roles'
        ],
        'permission' => [
            'text' => ' permissions'
        ],
    ] ,

    'tickets' => [
        'all' => [
            'text' => 'ticket management',
        ],
        'priority' => [
            'text' => 'proiority' ,
            'low' => 'low' ,
            'medium' => 'medium',
            'hight' => 'high'
        ] ,
        'subject' => 'subject' ,
        'message' => 'write your massage ...' ,
        'traking_code' => 'tracking code' ,
        'replay' => 'write your reply ...' ,
        'send' => 'send' ,
        'messages' => [
            'changestatus' => 'ticket closed seccessfuly .' ,
        ] ,
        'append' => 'add new ticket' ,
        'from_type' => [
            'text' =>  'how is the ticket seb to?' ,
            'my_role' => 'my group' ,
            'me' => 'me'
        ],
        'to_type' => [
            'text' => 'who do you want the ticket send for?' ,
            'role' => 'group' ,
            'user' => 'user'
        ] ,
        'notfound' => 'there is any item !'
    ] ,

    'profile' => [
        'name' => 'name' ,
        'family'  => 'family', 
        'firstname' => 'first name' ,
        'lastname'  => 'last name' ,
        'username' => 'user name' ,
        'email' => 'email' ,
        'mobile' => 'phone number' ,
        'instagram' => 'instagram account' ,
        'picture' => 'picture' ,
        'theme' => 'dashboard theme' ,
        'choose_picture' => 'choose picture' ,
        'select_one_type' => "select a picture" ,
        'password' => "password" ,
        'password_confirmation' => 'password confirmation' ,
        'themes' => [
            'green' => 'green'  ,
            'blue' => 'blue'  ,
            'yellow' => 'yellow'  ,
            'red' => 'red'  ,
        ],
        'gender' => 'sex' ,
        'genders' => [
            'male'  => 'male' ,
            'female' => 'female' ,
        ] ,
        'edit' => [
            'text' => 'edit profile' ,
            'desc' => 'edit your profile.'
        ] ,
        'changepassword' => [
            'text' => 'edit password' ,
            'desc' => 'edit your password.'
        ] ,
        'logout' => 'logout from profile' ,
        'select_one_color' => 'select a color .' ,
        'select_one_role' => 'select a user role .' ,
        'role' => 'user role' ,
        'status' => [
            'text' => 'user status' ,
            'desc' => 'you can enable/disable user access tmporary.'
        ] ,
        'just_status' => "show me system active status only ." ,
        'credit' => 'wallet'
    ],

    'roles' => [
        'all' => [
            'text' => 'role management',
            'desc' => 'you can manage(create,edit,delete) your user roles.'
        ],
        'create' => [
            'text' => 'create user role' ,
            'desc' => 'create new user role .'
        ] ,
        'edit' => [
            'text' => 'edit user role ' ,
            'text_with_attr' => 'edit user role :attribute' ,
            'desc' => 'edit user role .' ,
        ] ,
        'delete' => [
            'text' => 'delete user role' ,
            'text_with_attr' => 'delete role :attribute' ,
            'desc' => 'delete user role; .'
        ] ,
        'just_default' => "just show me system defult role ." ,
        'default' => [
            'text' => 'main role' ,
            'desc' => 'main role unable to delete, are you sure?'
        ],
        'permissions' => [
            'text' => 'select permissions' ,
            'desc' => 'select sightly permissions .' ,
            'without' => 'there is not permission  to show .'
        ]
    ],

    'permissions' => [
        'all' => [
            'text' => 'permissions management',
            'desc' => 'you can mnage(create,edit.delete)permission.'
        ],
        'delete' => [
            'text' => 'delete permission' ,
            'text_with_attr' => 'delete permission :attribute' ,
            'desc' => 'delete permission .'
        ] ,
        'create' => [
            'text' => 'create new permission' ,
            'desc' => 'create new permission .'
        ] ,
        'edit' => [
            'text' => 'edit permision' ,
            'text_with_attr' => 'edite permission :attribute' ,
            'desc' => 'edite permission .' ,
        ] ,
        'default' => [
            'text' => 'main permission' ,
            'desc' => 'main permission unable to delete, are you suer'
        ],
        'just_default' => "just show me default permission ." ,
    ],

    'users' => [
        'all' => [
            'text' => 'user management',
            'desc' => 'you can mange(creatw,edit,delete)user.'
        ],
        'edit' => [
            'text' => 'edit user' ,
            'text_with_attr' => 'edit user :attribute' ,
            'desc' => 'edit user .' ,
        ] ,
        'delete' => [
            'text' => 'delete user' ,
            'text_with_attr' => 'delete user :attribute' ,
            'desc' => 'delete user .'
        ] ,
        'create' => [
            'text' => 'create user'  ,
            'desc' => 'create new user and manage it .'
        ]
    ],

    'items' => [
        'slug' => 'short address' ,
        'created_at' => 'create time' ,
        'updated_at' => 'edit time' ,
        'name' => 'name' ,
        'username' => 'user name' ,
        'description' => 'description' ,
        'search' => 'search ...' ,
        'search_trakingcode' => 'tracking code ...' ,
        'filter' => 'filter' ,
        'id' => 'ID' ,
        'information' => 'more information' ,
        'sortby' => 'ordering' ,
        'users_count' => 'number of users'  ,
        'permissions_count' => 'numbe of permissions1' ,
        'create_new' => 'create new !' ,
        'create' => 'create' ,
        'roles_count' => 'number of role' ,
        'useage' => 'number of useage' ,
        'new' => 'new' ,
        'confrim_account' => 'user account confirmation' ,
        'deConfirm_account' => 'cancel confirmation' ,
        'update_account'  => 'edit user account' ,
        'status' => 'status' ,
        'select_one_type' => 'select an item ...'
    ],

    'messages' => [

        'success' => [
            'tickets' => [
                'create' => 'ticket ricoreded seccessfuly .' ,
            ],
            'profile' => [
                'update' => 'user profile edited seccessfuly.'
            ],
            'roles' => [
                'delete' => 'user profile deleted seccessfuly .' ,
                'update' => 'user profile edited seccessfuly.' ,
                'store'  => 'user profile created seccessfuly .' ,
            ],
            'permissions' => [
                'delete' => 'permission profile deleted seccessfuly .' ,
                'update' => 'permission profile edited seccessfuly.' ,
                'store'  => 'permission profile craeted seccessfuly .' ,
            ] ,
            'users' => [
                'delete' => 'user deleted seccessfuly .' ,
                'update' => [
                    'profile' => 'user profile edited seccessfuly.' ,
                    'password' => 'user password edited seccessfuly.' ,
                ] ,
                'store'  => 'user created seccessfuly .' ,
            ],
            'discounts' => [
                'create' => 'discoun coupon created seccessfuly .' ,
                'update' => 'discoun coupon updated seccessfuly .'
            ] ,
            'credit' => [
                'pay' => 'thanks for pay, your user account created seccessfuly .'
            ]
        ],
        'errors' => [
            'access' => 'you can not access and show this part .' ,
            'status' => 'your access to login to system rigid,please contact with management.' ,
            'delete_fail' => 'you are unable to delete .' ,
        ],
    ],

    'questions' => [
        'role_delete' => "if you delete this role all affiliations will be delete\n are you want to delete this role?  " ,
        'permission_delete' => "if you delete this permission all affiliations will be delete\n are you want to delete this permission? " ,
        'user_delete' => "  if you delete this user all affiliations will be delete\n are you want to delete this user?  ." ,
    ],

    'period_time' => [
        'all'   => 'all information' ,
        'today' => 'today' ,
        'yesterday' => 'yesterday' ,
        '1week'  => 'last week' ,
        '2week' => 'two weeks ago' ,
        '3week' => 'three weeks ago'  ,
        '1month' => 'last month'  ,
        '2month' => 'two month ago'  ,
        '3month' => 'three month ago' ,
        '6month' => 'six month ago' ,
        '1year' => ' last year' ,
    ],

    'order' => [
        'asc' => 'ascending' ,
        'desc' => 'descending'
    ] ,

    'status' => [
        'false' => 'disable' ,
        'true' => 'enable' ,
        '0' => 'disable' ,
        '1' => 'enable' ,
        'payment' => [
            'INIT' => 'loading' ,
            'SUCCEED' => 'succeed' ,
            'FAILED' => 'failed'
        ]
    ],

    'sidebar' => [
        'main_menu' => 'main menu' ,
        'roles' => 'roles' ,
        'accesses' => 'accesses' ,
        'dashboard' => 'dhashboard' ,
        'users' => 'users' ,
        'tickets' => 'tickets' ,
        'discounts' => 'discount coupons' ,
        'factor' => 'factors' ,
        'factor_payment' => 'payments'
    ] ,

    'errors' => [
        '404' => [
            'text' => 'porsapp,page founded.' ,
            'desc' => ' sorry! 404 error happened, page not founded .' ,
        ]
    ] ,

    'currency' => [
        'rial' => 'rial' ,
        'thousandrial' => 'thousand rial' ,
        'toman' => 'toman' ,
        'thousandtoman' => 'thousand toman' ,
    ] ,

    'credit' => [
        'charge' => [
            'text' => 'charge wallet' ,
            'desc' => 'you can increase youe wallet inventory .'
        ] ,
        'price'  => 'charge price' ,
        'placeholder' => 'enter your charge price ...' ,
        'Paynow' => 'pay now' ,
        'ihave_discount' => 'i have discount code' ,
        'ihavenot_discount' => 'i do not have discount code' ,
        'enterdiscount' => 'enter your discount code'

    ] ,

    'discounts' => [
        'label' => 'discount coupon' ,
        'show_label' => 'show discount coupon' ,
        'show_desc'  => 'edit discount coupon .' ,
        'desc'  => 'create discount coupon or manage your discount coupon .' ,
        'all'   => 'coupons' ,
        'usage' => 'usage' ,
        'how_long' => 'expiration' ,
        'more'  => 'اmor information' ,
        'search'=> 'enter discount coupon ..' ,
        'create'=> 'craete discount coupon' ,
        'number_of_use' => 'number of usage' ,
        'code'  => 'discount code' ,
        'expired_at' => 'expirration time' ,
        'percent' => 'percentage of discount' ,
        'percent_label' => 'enter percentage of discount .' ,
        'amount'  => 'deductible price' ,
        'amount_label'  => 'how much do you want to deduct your price .' ,
        'edit' => 'edit discount coupon' ,
        'edit_button' => 'edit'
    ] ,

    'factor' => [
        'label'  => 'payment factor' ,
        'amount' => ' paid amount ' ,
        'created_at' => 'payment time' ,
        'coupon' => 'discount coupon' ,
        'tracking_code' => 'tracking code' ,
        'transaction_id' => 'transaction id' ,
        'charge' => 'chaged amount' ,
        'payment' => 'payment factor' ,
        'payment_label' => 'shaow all payment factor'
    ] ,

    'table' => [
        'created_at' => 'craete time' ,
        'status' => 'status' ,
        'bank' => 'bank' ,
        'price' => 'price' ,
        'transaction_id' => 'transaction id' ,
        'tracking_code'  => 'tracking code' ,
        'username' => 'user name' ,
        'discount_code' => 'discount code' ,
        'filter_payments' => 'search payments' ,
        'credit' => 'inventory'
    ]
];