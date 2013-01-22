<?php

$items = $modx->fromJSON($scriptProperties['items']);

if(is_array($items)){
    foreach($items as $sortorder => $fields){
        if($image = $modx->getObject('modRedirect', $fields['id'])){
            $image->fromArray($fields);
            $image->set('sortorder', ($sortorder));
            $image->save();
        }
    }
}

return $modx->error->success();