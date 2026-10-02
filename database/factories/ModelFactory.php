<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Base\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(\App\Models\Specific\Product::class,function (\Faker\Generator $faker){
    $index=rand(1,100);
    return [
        'brand_id'=>\App\Models\Specific\Brand::inRandomOrder()->first()->id,
        'title'=>'محصول '.$index,
        'summery'=>'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. ',
        'description'=>'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ',
        'country'=>'ایران',
        'options'=>json_encode([]),
        'guarantee'=>'2 سال'
    ];
});
$factory->define(\App\Models\Specific\ServiceRequest::class,function (\Faker\Generator $faker){
    return [
        'user_id'=>5,
        'name'=>$faker->firstName,
        'phone'=>$faker->phoneNumber,
        'email'=>$faker->email,
        'address'=>$faker->address,
        'description'=>$faker->text,
    ];
});
