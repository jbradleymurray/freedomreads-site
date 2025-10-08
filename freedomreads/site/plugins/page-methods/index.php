<?php

Kirby::plugin('fr/page-methods', [
    'pageMethods' => [
        'getState' => function () {
            $stateName = '';
            if( $this->prisonlocation()->isNotEmpty() ){
                $stateName = $this->prisonlocation()->yaml()['region'];
            };
            return $stateName;
        },
        'getStateIndex' => function () {
            $states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming');
            $stateIndex = 0;
            if( $this->prisonlocation()->isNotEmpty() ){
                $state = $this->prisonlocation()->yaml()['region'];
                $stateIndex = array_search($state, $states);
            };
            return $stateIndex;
        }
    ]
]);