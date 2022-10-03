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

    public function taskTwo($input_string)
    {
        $this->temp_array = array_map('strval', str_split($input_string));

        $matching_array = [];

        $alphabet_array = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

        array_push($matching_array,$alphabet_array);

        array_push($matching_array,Arr::crossJoin($alphabet_array,$alphabet_array));

        array_push($matching_array,Arr::crossJoin($alphabet_array,$alphabet_array,$alphabet_array));

        $matching_array = Arr::collapse($matching_array);

        $index = Arr::where($matching_array,function($value,$key){
            if($this->temp_array === $value)
            {
                // dd($key);
                return $key;
            }
        });

        foreach($index as $key=>$val)
        {
            return response()->json($key+1);
        }

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
