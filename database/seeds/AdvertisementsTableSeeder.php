<?php

use Illuminate\Database\Seeder;
use App\Entities\Advertisement;

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $advertisement = [
            'name'          => '微笑表情包',
            'sequence'      => "",
            'round_time'    => (int) 10,
            'weeks'         => ["1","2","3","4","5","6","7"],
            'broadcast_time'=> "9:00~17:00",
            'publish_at'    => new \MongoDB\BSON\UTCDateTime(strtotime("now") * 1000),
            'status'        => 1,
            'format'        => [
                "extension" => "jpg", 
                "mime_type" => "image/jpeg", 
                "size" => "26.42 KB", 
                "width" => "636 px", 
                "height" => "423 px"
            ],
            'path' => '/uploads/advertisement/default.jpg',
        ];

        Advertisement::create($advertisement);
    }
}
