<?php

//fonction nettoyage formulaire
class Fonction {
    static function cleanData($data){
        return htmlentities(strip_tags(stripslashes(trim($data))));
    }
}
