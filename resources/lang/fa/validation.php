<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'mobile' => 'موبایل وارد شده نامعتبر است.',
    'national_code' => 'کد ملی وارد شده نا معتبر است.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'فیلد :attribute باید یک آرایه باشد.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'فیلد :attribute باید بین :min و :max باشد.',
        'file' => 'فیلد :attribute باید بین :min و :max کلوبایت باشد.',
        'string' => 'فیلد :attribute باید بین :min و :max کاراکتر باشد.',
        'array' => 'فیلد :attribute باید بین :min و :max آیتم داشته باشد.',
    ],
    'boolean' => 'فیلد :attribute باید صحیح یا غلط باشد.',
    'confirmed' => 'فیلد :attribute و تأیید آن با هم برابر نیستند.',
    'date' => 'فیلد :attribute یک تاریخ معتبر نیست.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'فیلد :attribute باید به صورت معتبر باشد.',
    'exists' => ':attribute وارد شده نامعتبر است.',
    'file' => 'فیلد :attribute باید یک فایل باشد.',
    'filled' => 'فیلد :attribute باید یک مقدار داشته باشد.',
    'image' => 'فیلد :attribute باید یک عکس باشد.',
    'in' => 'فیلد :attribute انتخاب شده نامعتبر است.',
    'in_array' => 'فیلد :attribute درون :other وجود ندارد.',
    'integer' => 'فیلد :attribute باید یک عدد صحیح باشد.',
    'ip' => 'فیلد :attribute باید یک آدرس IP معتبر باشد.',
    'json' => 'فیلد :attribute باید یک رشته JSON معتبر باشد.',
    'max' => [
        'numeric' => 'فیلد :attribute نباید بزرگتر از :max باشد.',
        'file' => 'فیلد :attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'string' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
        'array' => 'فیلد :attribute نباید بیشتر از :max آیتم داشته باشد.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'فیلد :attribute حداقل باید :min باشد.',
        'file' => 'فیلد :attribute حداقل باید :min کیلوبایت باشد.',
        'string' => 'فیلد :attribute حداقل باید :min کاراکتر داشته باشد.',
        'array' => 'فیلد :attribute حداقل باید :min آیتم داشته باشد.',
    ],
    'not_in' => 'فیلد :attribute انتخاب شده نامعبر است.',
    'numeric' => 'فیلد :attribute باید به صورت عددی وارد شود.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'فیلد :attribute نامعتبر است.',
    'required' => 'فیلد :attribute الزامی است.',
    'required_if' => 'فیلد :attribute الزامی است وقتی که مقدار :other برابر :value باشد.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values is present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
//    'same' => 'The :attribute and :other must match.',
    'same' => 'فیلد :attribute و :other باید با هم برابر باشند.',
    'size' => [
        'numeric' => 'فیلد :attribute باید :size باشد.',
        'file' => 'فیلد :attribute باید :size کیلوبایت باشد.',
        'string' => 'فیلد :attribute باید :size کاراکتر باشد.',
        'array' => 'فیلد :attribute باید شامل :size آیتم باشد.',
    ],
    'string' => 'فیلد :attribute باید به صورت رشته ای باشد.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'این :attribute قبلا ثبت شده است.',
    'uploaded' => 'آپلود فیلد :attribute ناموفق بوده است.',
    'url' => 'فرمت :attribute نامعتبر است.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],


        // Content Field -----------------------------------
//        'title' => [
//            'required' => 'فیلد عنوان الزامی است.',
//        ],
//
//        'main_image' => [
//            'required' => 'انتخاب عکس الزامی است.',
//        ],
//        'cat_image' => [
//            'required' => 'انتخاب عکس برای دسته بندی الزامی است.',
//        ],
//        'name' => [
//            'required' => 'فیلد نام الزامی است.',
//        ],
//        'family' => [
//            'required' => 'فیلد نام خانوادگی الزامی است.',
//        ],
//        'melli' => [
//            'required' => 'فیلد کد ملی الزامی است.',
//            'numeric' => 'فیلد کد ملی باید به صورت عددی وارد شود.',
//        ],
//        'birthday' => [
//            'required' => 'فیلد  تاریخ تولد الزامی است.',
//        ],
//        'day' => [
//            'required' => 'فیلد  روز الزامی است.',
//        ],
//        'month' => [
//            'required' => 'فیلد  ماه الزامی است.',
//        ],
//        'year' => [
//            'required' => 'فیلد  سال الزامی است.',
//        ],
//        'display' => [
//            'required' => 'فیلد  نمایش الزامی است.',
//        ],
//        'position' => [
//            'required' => 'فیلد  موقعیت الزامی است.',
//        ],
//
//        // Social Field ------------------------------------
//        'telegram' => [
//            'required' => 'فیلد تلگرام الزامی است.',
//            'url' => 'لینک تلگرام وارد شده، معتبر نیست.',
//        ],
//        'instagram' => [
//            'required' => 'فیلد اینستاگرام الزامی است.',
//            'url' => 'لینک اینستاگرام وارد شده، معتبر نیست.',
//        ],
//        'linkedin' => [
//            'required' => 'فیلد لینکدین الزامی است.',
//            'url' => 'لینک لینکدین وارد شده، معتبر نیست.',
//        ],
//        'gp' => [
//            'required' => 'فیلد گوگل پلاس الزامی است.',
//            'url' => 'لینک گوگل پلاس وارد شده، معتبر نیست.',
//        ],
//        'whatsapp' => [
//            'required' => 'فیلد واتس اپ الزامی است.',
//        ],

        // Anythings you need should be here ----------------

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'icon' => 'آیکون',
        'menu_image' => 'عکس منو',
        'main_image' => 'عکس اصلی',
        'name' => 'نام',
        'family' => 'نام خانوادگی',
        'email' => 'ایمیل',
        'password' => 'کلمه عبور',
        'current_password' => 'کلمه عبور فعلی',
        'mobile' => 'موبایل',
        'access_code' => 'کد دسترسی',
        'issue_tracking' => 'شماره ردیابی محموله',
        'pic' => 'عکس',
        'activity' => 'حوزه فعالیت',
        'national_card' => 'تصویر کارت ملی',
        'tracking_code' => 'شماره تراکنش/پیگیری',
        'artist_category_id'=>'دسته بندی هنرمند',
        'title'=>'عنوان',
        'description'=>'توضیحات ',
        'artists'=>'هنرمندان',
        'subtitle'=>'زیر عنوان',
        'address'=>'آدرس',
        'phone'=>'تلفن',
        'support_phone'=>'تلفن پشتیبانی',
        'longitude'=>'طول جغرافیایی',
        'latitude'=>'عرض جغرافیایی',
        'price'=>'قیمت',
        'duration'=>'مدت',
        'duration_type'=>'نوع مدت',
        'value'=>'مقدار',
        'count'=>'تعداد',
        'code'=>'کد',
        'discount'=>'تخفیف',
        'amount'=>'مقدار',
        'extension'=>'پسوند',
        'message'=>'پیام',
        'bank_cart_id'=>'کارت بانکی'
    ],


];
