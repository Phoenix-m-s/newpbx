<?php
class StepForm
{
    private $step;
    public $data;
    private $count;
    public $tpl;
    public $formName;
    public $brandName;
    public $file;

    public function __construct($formName, $count)
    {
        $this->formName = $formName;
        $this->count = $count;
        $this->step = 1;
    }

    //********************************************

    function delete()
    {
        unset ($_SESSION[$this->formName]);
    }

    //********************************************


    public function object($formName, $count)
    {
        if (!isset($_SESSION[$formName])) {
            $stepForm = new stepForm($formName, $count);
        } else {
            $stepForm = unserialize($_SESSION[$formName]);
        }
        return $stepForm;
    }

    function save()
    {
        $_SESSION[$this->formName] = serialize($this);
    }

    //********************************************
    public function getCount()
    {
        return $this->count;
    }

    //********************************************
    public function getTemplate($step = 0)
    {
        if ($step == '0') {
            $step = $this->step;
        }
        return $this->tpl . '' . $step;
    }


    public function setTemplate($tpl)
    {
        $this->tpl = $tpl;
    }
    //********************************************
    public function setStep($_input)
    {
        if ($_input <= $this->count) {
            $this->step = $_input;
        }
    }

    //********************************************
    public function getStep()
    {
        return $this->step;
    }

    //********************************************
    public function setData($_input, $step = 0)
    {
        if ($step == '0') {
            $step = $this->step;
        }
        $this->data[$step] = $_input;
    }

    //********************************************
    public function getData($step = 0)
    {
        if ($step == '0') {
            $step = $this->step;
        }

        return $this->data[$step];
    }
    //********************************************
}
