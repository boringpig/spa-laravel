<?php

use Illuminate\Database\Seeder;
use App\Entities\AreaGroup;
use App\CPS\Repositories\SCityRepository;

class AreaGroupsTableSeederr extends Seeder
{

    protected $sCityRepository;

    public function __construct(
        SCityRepository $sCityRepository
    ) {
        $this->sCityRepository = $sCityRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s_citys = $this->sCityRepository->getAll()->toArray();
        $s_citys = collect($s_citys)->map(function($item) {
            return [
                'parent_area' => "{$item['province']}{$item['country_id']}",
                'child_area' => [],
            ];
        })->toArray();

        AreaGroup::insert($s_citys);
    }
}
