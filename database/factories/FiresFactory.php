<?php

use Faker\Generator as Faker;
namespace Database\Factories;
use App\Fires;
use Illuminate\Database\Eloquent\Factories\Factory;
class FiresFactory extends Factory
{
    public function definition()
    {
        $time = mt_rand(strtotime('2018-01-01'), time());
        return [
            'uploader_id'=>random_int(166,173),
            'editor_id'=>random_int(166,173),
            'date'=>date("Y-m-d H:i:s",$time),
            'incident_images'=>"",
            'description'=>strip_tags(file_get_contents('http://loripsum.net/api/1/short')),
            'casualties'=>random_int(0,100),
            'damages'=>round(random_int(100,1000)/100,2),
            'latitude'=>"16.".(random_int(1000,3155569406)),
            'longitude'=>"120.".(random_int(5000,99999)),
            'reportedby'=> fake()->name(),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s")
        ];
    }
}
/* $factory->define(App\Fires::class, function (Faker $faker) {
    $time = mt_rand(strtotime('2018-01-01'), time());
    return [
        'uploader_id'=>random_int(166,173),
        'editor_id'=>random_int(166,173),
        'date'=>date("Y-m-d H:i:s",$time),
        'incident_images'=>"",
        'description'=>strip_tags(file_get_contents('http://loripsum.net/api/1/short')),
        'casualties'=>random_int(0,100),
        'damages'=>round(random_int(100,1000)/100,2),
        'latitude'=>"16.".(random_int(1000,3155569406)),
        'longitude'=>"120.".(random_int(5000,99999)),
        'reportedby'=> fake()->name(),
        'created_at'=>date("Y-m-d H:i:s"),
        'updated_at'=>date("Y-m-d H:i:s")
    ];
}); */
