<?php

namespace App\Http\Controllers\Problems;

use App\Traits\ApiResponseTrait;

class StepNumber
{
    use ApiResponseTrait;

    public function calcStepsToReduceNumberToZero()
    {

        request()->validate([
            'q' => 'required|array',
            'q.*' => 'integer|min:0',
        ]);

        $myArr = request('q');
        $numberOfSteps = [];

        for ($i = 0, $length = count($myArr); $i < $length; $i++) {
            $steps = 0;

            while ($myArr[$i] > 0) {
                if ($myArr[$i] % 2 == 1) {
                    // this is odd number
                    $myArr[$i]--;
                    $steps++;
                } else {
                    // this is even number
                    $myArr[$i] = $myArr[$i] / 2;
                    $steps++;
                }
            }

            $numberOfSteps[] = $steps;
        }

        $data['number_of_steps'] = $numberOfSteps;
        return $this->apiResponse($data);
    }
}
