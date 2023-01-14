<?php

namespace App\Http\Controllers\Problems;

use App\Traits\ApiResponseTrait;

class CountOfNumbers
{

    use ApiResponseTrait;

    public function count()
    {

        request()->validate([
            'start_number' => 'required|integer',
            'end_number' => 'required|integer|gt:start_number',
        ]);

        $numbersCount = 0;
        for ($i = request('start_number'); $i <= request('end_number'); $i++) {
            if (str_contains((string) $i, "5")) {
                continue;
            }
            $numbersCount++;
        }
        $data['numbers_count'] = $numbersCount;
        
        return $this->apiResponse($data);
    }
}
