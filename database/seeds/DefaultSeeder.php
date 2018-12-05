<?php
use App\Models\Role;
use Illuminate\Database\Seeder;
class DefaultSeeder extends Seeder
{
    public function run()
    {
        $permission =
        [
            [
                "name" => "permission" ,
                "description" => "مدیریت پرمیشن ها" ,
                "default" => true
            ],
            [
                "name" => "role" ,
                "description" => "مدیریت نقش ها",
                "default" => true
            ],
            [
                "name" => "user" ,
                "description" => "مدیریت کاربران" ,
                "default" => true
            ],
            [
                "name" => "ticket" ,
                "description" => "مدیریت تیکت ها" ,
                "default" => true
            ],
            [
                "name" => "discount" ,
                "description" => "مدیریت تخفیف ها" ,
                "default" => true
            ],
            [
                "name" => "credit" ,
                "description" => "شارژ کیف پول" ,
                "default" => true
            ],
            [
                "name" => "factor.payments" ,
                "description" => "فاکتورهای پرداخت" ,
                "default" => true
            ],
            [
                "name" => "factor.mypayments" ,
                "description" => "فاکتورهای پرداخت من" ,
                "default" => true
            ],

        ];
        $role = Role::create([
            "name" => "administator" ,
            "description" => "مجاز و دسترسی کامل به اطلاعات" ,
            "default" => true
        ]);
        $role->permissions()->createMany($permission) ;
        $role->users()->create([
            "username" => "test" ,
            'firstname' => 'تست' ,
            'lastname' => 'تست نیا' ,
            "mobile"   => "" ,
            "email"    => "test@ghaninia.ir" ,
            "password" => bcrypt("secret") ,
        ]);
    }
}
