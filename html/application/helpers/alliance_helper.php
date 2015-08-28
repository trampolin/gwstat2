<?php

function getAllianceLabel($allianceId,$allianceTag, $id = null, $customClass = null) {
    return '<a '.($id === null ? '' : 'id="'.$id.'" ').'class="label label-alliance'.($customClass === null ? '' : ' '.$customClass).'" data-alliance-id="'.$allianceId.'" data-target="#allianceModal" data-toggle="modal">'.$allianceTag.'</a>';
}