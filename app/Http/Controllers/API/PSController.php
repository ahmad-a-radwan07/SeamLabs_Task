<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PSController extends Controller
{
    public $temp_array;

    public function taskOne($param_one,$param_two)
    {
        $counter = 0;
        if($param_one < $param_two)
        {
            for($i = $param_one; $i <= $param_two; $i++)
            {
                $temp_array = collect(array_map('intval', str_split($i)));
                if(!$temp_array->contains(5))
                {
                    $counter++;
                }
            }
            return response()->json($counter);
        }
        else
        {
            return response()->json('ERROR: param_one is greater than or equal to param_two');
        }
    }

    // 26^l-1  * q
    public function taskTwo($input_string)
    {
        $index = 0;
        $input_string_arr = array_map('strval', str_split($input_string));


        $alphabet_array = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

        $input_string_len = strlen($input_string);
        $j = 0;
        for($i = $input_string_len - 1; $i >= 0; $i--)
        {
            if($j < $input_string_len)
            {
                $index += pow(26, $i) * (array_search($input_string_arr[$j++],$alphabet_array)+1);
            }
        }

        return response()->json($index);
    }

    public function taskThree($N, $Q)
    {
        $final_res = [];

        $Q = str_replace('[','',$Q);
        $Q = str_replace(']','',$Q);

        $temp_q = preg_split ("/\,/", $Q);

        foreach($temp_q as $item)
        {
            $step_counter = 0;

            $q = $item;

            while($q > 0)
            {
                $factors = $this->numFactors($q);

                $factor_count = count($factors);

                if($factor_count%2 == 0)
                {
                    $upper_index = $factor_count/2;
                    $lower_index = ($factor_count/2) - 1;
                }
                else
                {
                    $upper_index = floor($factor_count/2);
                    $lower_index = floor($factor_count/2);
                }

                if($factors[$upper_index] != 1 && $factors[$lower_index] != 1)
                {
                    $q = max($factors[$upper_index],$factors[$lower_index]);
                    $step_counter++;
                }
                else
                {
                    $q--;
                    $step_counter++;
                }
            }

            array_push($final_res,$step_counter);
        }
        return response()->json($final_res);
    }

    private function numFactors($product)
    {
        $result = [];
        for($i=1;$i<=((int)$product/2); $i++){
            if((int)$product%$i == 0 )
            {
                array_push($result,$i);
            }
        }
        array_push($result,(int)$product);

        return $result;
    }
}
