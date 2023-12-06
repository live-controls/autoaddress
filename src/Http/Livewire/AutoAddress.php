<?php

namespace LiveControls\AutoAddress\Http\Livewire;

use LiveControls\AutoCep\Scripts\GetCEP;
use Illuminate\Support\Facades\Log;
use LiveControls\AutoAddress\Objects\CepAbertoResponse;
use LiveControls\AutoAddress\Objects\ZipCodebaseResponse;
use LiveControls\AutoAddress\Scripts\CepAberto;
use LiveControls\Utils\Utils;
use Livewire\Component;

class AutoAddress extends Component
{
    public $backend; //Either cepaberto or zipcodebase

    public $prefix = '';
    public $titlesuffix = '';
    public $oldmodel = null; //If this is set, it will try to read from this model (Needed for editing)

    public $required;

    public $areaCodeValue;
    public $areaCode = null;
    public $oldAreaCode = null;
    public $street = '';
    public $area = '';
    public $city = '';
    public $state = '';
    public $country = '';

    public $valid = -1;

    private bool $firststart = false;


    //CUSTOM FORM CONTROL NAMES
    public $areacodeName = 'areacode';
    public $streetName = 'street';
    public $numberName = 'housenumber';
    public $complementName = 'complement';
    public $areaName = 'area';
    public $cityName = 'city';
    public $stateName = 'state';
    public $countryName = 'country';

    protected $listeners = [
        'areacodeUpdated' => 'fetchInfos'
    ];

    public function mount(){
        if(is_null($this->backend))
        {
            $this->backend = "cepaberto";
        }

        if(is_null($this->country)){
            $this->country = "br";
        }
        
        if(is_null($this->required))
        {
            $this->required = false;
        }
        if(!is_null($this->oldmodel))
        {
            $this->firststart = true;
            $this->areaCode = $this->oldmodel->{$this->prefix.$this->areacodeName};
            $this->areaCodeValue = $this->areaCode;
            $this->street = $this->oldmodel->{$this->prefix.$this->streetName};
            $this->area = $this->oldmodel->{$this->prefix.$this->areaName};
            $this->state = $this->oldmodel->{$this->prefix.$this->stateName};
            $this->city = $this->oldmodel->{$this->prefix.$this->cityName};
        }
    }

    public function render()
    {
        if(is_numeric($this->areaCode) && $this->firststart == false && $this->cep != $this->oldcep)
        {
            $this->fetchInfos();
            $this->oldAreaCode = $this->areaCode;
        }
        $this->firststart = false;
        return view('livecontrols-autoaddress::livewire.input');
    }

    public function updated($name, $value)
    {
        if($name == "cepvalue")
        {
            $this->emit($this->prefix.$this->areacodeName.'-valueUpdated', ['value' => $value]);
        }
    }

    public function checkInfos(): bool
    {
        if($this->backend == "cepaberto"){
            return $this->areaCode == null || $this->areaCode == '' || !is_numeric($this->areaCode) ? false : Utils::countNumber($this->areaCode) == 8;
        }
        return $this->areaCode == null || $this->areaCode == '';
    }

    public function fetchInfos()
    {
        if(!$this->checkInfos())
        {
            return;
        }
        $this->valid = -1;
        if($this->backend == "cepaberto"){
            $result = new CepAbertoResponse($this->areaCode);
            if(!$result->isValid()){
                $this->valid = 0;
                return;
            }
            $this->state = $result->state;
            $this->city = $result->city;
            $this->area = $result->area;
            $this->street = $result->street;
        }else{
            $response = new ZipCodebaseResponse($this->areaCode, $this->country);
            if(!$response->isValid()){
                $this->valid = 0;
                return;
            }
            //Fetch result at index 0 because only one areacode was added
            $result = $response->results[0];
            $this->state = $result->state;
            $this->city = $result->city;
        }
    }
}
