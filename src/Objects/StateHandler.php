<?php

namespace LiveControls\AutoAddress\Objects;

use Exception;

class StateHandler
{
    /**
     * List of States
     */
    const STATES = [
        'AC'=>'Acre',
        'AL'=>'Alagoas',
        'AP'=>'Amapá',
        'AM'=>'Amazonas',
        'BA'=>'Bahia',
        'CE'=>'Ceará',
        'DF'=>'Distrito Federal',
        'ES'=>'Espírito Santo',
        'GO'=>'Goiás',
        'MA'=>'Maranhão',
        'MT'=>'Mato Grosso',
        'MS'=>'Mato Grosso do Sul',
        'MG'=>'Minas Gerais',
        'PA'=>'Pará',
        'PB'=>'Paraíba',
        'PR'=>'Paraná',
        'PE'=>'Pernambuco',
        'PI'=>'Piauí',
        'RJ'=>'Rio de Janeiro',
        'RN'=>'Rio Grande do Norte',
        'RS'=>'Rio Grande do Sul',
        'RO'=>'Rondônia',
        'RR'=>'Roraima',
        'SC'=>'Santa Catarina',
        'SP'=>'São Paulo',
        'SE'=>'Sergipe',
        'TO'=>'Tocantins'
    ];

    /**
     * Returns the full name of the state
     *
     * @param string $uf
     * @throws Exception
     * @return string
     */
    public static function find(string $uf):string
    {
        if(strlen($uf) != 2){
            throw new Exception("Invalid UF length, needs to be exactly 2 characters long!");
        }
        $uf = strtoupper($uf);
        if(!array_key_exists($uf, static::STATES)){
            throw new Exception("State with UF '".$uf."' does not exist!");
        }
        return static::STATES[$uf];
    }
}