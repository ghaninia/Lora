<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            "name" => "administator",
            "description" => "مجاز و دسترسی کامل به اطلاعات",
            "default" => true
        ]);
        $role->permissions()->createMany([
            [
                "name" => "permission",
                "description" => "مدیریت پرمیشن ها",
                "default" => true
            ],
            [
                "name" => "role",
                "description" => "مدیریت نقش ها",
                "default" => true
            ],
            [
                "name" => "user",
                "description" => "مدیریت کاربران",
                "default" => true
            ],
            [
                "name" => "ticket",
                "description" => "مدیریت تیکت ها",
                "default" => true
            ],
            [
                "name" => "discount",
                "description" => "مدیریت تخفیف ها",
                "default" => true
            ],
            [
                "name" => "credit",
                "description" => "شارژ کیف پول",
                "default" => true
            ],
            [
                "name" => "factor.payments",
                "description" => "فاکتورهای پرداخت",
                "default" => true
            ],
            [
                "name" => "factor.mypayments",
                "description" => "فاکتورهای پرداخت من",
                "default" => true
            ],
            [
                "name" => "option",
                "description" => "تنظیمات",
                "default" => true
            ],

        ]);

        $role->users()->create([
            "username" => "test",
            'firstname' => 'لورا',
            'lastname' => 'اسکریپت',
            "mobile"   => "",
            "email"    => "admin@digilora.ir",
            "password" => bcrypt("secret"),
        ]);

        Option::insert([
            [
                "key" => "site_logo",
                "value" => null,
                "default" => null,
            ], [
                "key" => "site_favicon",
                "value" => null,
                "default" => null,
            ], [
                "key" => "site_perview",
                "value" => null,
                "default" => null,
            ], [
                "key" => "site_title",
                "value" => null,
                "default" => config("lora.title"),
            ], [
                "key" => "site_description",
                "value" => null,
                "default" => config("lora.desc"),
            ], [
                "key" => "site_copyright",
                "value" => null,
                "default" => config("lora.copyright"),
            ], [
                "key" => "paginate_size",
                "value" => null,
                "default" => config("lora.paginate_size"),
            ], [
                "key" => "max_credit",
                "value" => null,
                "default" => config("lora.max_credit"),
            ], [
                "key" => "thumb_width",
                "value" => null,
                "default" => config("lora.thumb_width"),
            ], [
                "key" => "thumb_height",
                "value" => null,
                "default" => config("lora.thumb_height"),
            ], [
                "key" => "min_credit",
                "value" => null,
                "default" => config("lora.min_credit"),
            ], [
                "key" => "user_can_regsiter",
                "value" => null,
                "default" => config("lora.user_can_regsiter"),
            ], [
                "key" => "user_default_role",
                "value" => null,
                "default" => config("lora.user_default_role"),
            ], [
                "key" => "limit_buy_time",
                "value" => null,
                "default" => config("lora.limit_buy_time"),
            ], [
                "key" => "telegram_id",
                "value" => null,
                "default" => config("lora.social.telegram_id"),
            ], [
                "key" => "instagram_id",
                "value" => null,
                "default" => config("lora.social.instagram_id"),
            ], [
                "key" => "gmail_id",
                "value" => null,
                "default" => config("lora.social.gmail_id"),
            ], [
                "key" => "yahoo_id",
                "value" => null,
                "default" => config("lora.social.yahoo_id"),
            ], [
                "key" => "log_email",
                "value" => null,
                "default" => config("lora.log.email"),
            ], [
                "key" => "keywords",
                "value" => null,
                "default" => json_encode(config("lora.keywords")),
            ], [
                "key" => "site_address",
                "value" => null,
                "default" => null,
            ], [
                "key" => "site_tellphone",
                "value" => null,
                "default" => null,
            ], [
                "key" => "site_email",
                "value" => null,
                "default" => null,
            ],

        ]);
    }
}
