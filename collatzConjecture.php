<?php

class CollatzConjecture
{
    private $iterations;
    private $sequence;
    private $num;
    private function sequenceGen($num)
    {
        $seq = array();

        $temp = $num;

        array_push($seq, $temp);

        while ($temp != 1) {
            if (fmod($temp, 2) == 0)
                $temp /= 2;
            else
                $temp = ($temp * 3) + 1;

            array_push($seq, $temp);
        }
        return $seq;
    }

    function __construct($num)
    {
        $this->num = $num;
        $this->sequence = $this->sequenceGen($num);
        $this->iterations = count($this->sequence) - 1;
    }

    function get_sequence()
    {
        return $this->sequence;
    }
    function get_iterations()
    {
        return $this->iterations;
    }
    function get_num()
    {
        return $this->num;
    }
    function get_highIteration()
    {
        $maxVal = $this->num;
        foreach ($this->sequence as $elem) {
            if ($elem > $maxVal)
                $maxVal = $elem;
        }
        return $maxVal;
    }

}



class CollatzConjectureRange
{
    private $from;
    private $to;

    protected $result;

    private function genRangeRes($from, $to)
    {
        $res = array();
        for ($i = $from; $i <= $to; $i++) {
            $elem = new CollatzConjecture($i);
            array_push($res, $elem);
        }
        return $res;
    }

    function __construct($from, $to = null)
    {
        $this->from = $from;
        $this->to = $to ? $to : $from;
        $this->result = $this->genRangeRes($this->from, $this->to);
    }

    function getResults()
    {
        return $this->result;
    }

    function get_fibonacciProgression()
    {
        $i = 2;
        $fib = [0, 1];
        $res = array();
        $nextTerm = null;

        while ($nextTerm < $this->to) {
            $nextTerm = $fib[$i - 1] + $fib[$i - 2];

            if ($nextTerm > $this->to)
                break;
            $fib[] = $nextTerm;

            if ($nextTerm >= $this->from) {
                $elem = new CollatzConjecture($nextTerm);
                array_push($res, $elem);
            }
            $i++;
        }
        return $res;
    }

    function get_Max_Min($sequence)
    {
        $res = array();
        $min = $sequence[0];
        $max = $sequence[0];

        foreach ($sequence as $elem) {
            if ($elem->get_iterations() > $max->get_iterations())
                $max = $elem;

            if ($elem->get_iterations() < $min->get_iterations())
                $min = $elem;
        }
        array_push($res, $min);
        array_push($res, $max);
        return $res;
    }
}
class Diagram extends CollatzConjectureRange
{
    private $yAxis;
    private $xAxis;

    private function genData()
    {
        $yValue = array();
        $xValue = array();

        foreach ($this->result as $elem) {
            $yValue[] = $elem->get_iterations();
            $xValue[] = $elem->get_num();
        }
        $this->yAxis = $yValue;
        $this->xAxis = $xValue;
    }

    function __construct($from, $to = null)
    {
        parent::__construct($from, $to);
        $this->genData();
    }


    function getYAxis()
    {
        return json_encode($this->yAxis);
    }
    function getXAxis()
    {
        return json_encode($this->xAxis);
    }
}

?>