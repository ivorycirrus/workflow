<?php
$url='http://zvezda.iptime.org:8080/wiki/index.php/workflow_test';
$text=file_get_contents($url);

$temp=@explode('[!workflow!]',$text);
$temp=@explode('[/!workflow!]',$temp[1]);

$text=$temp[0];
$text=str_replace('&quot;','"',$text);

$script = json_decode($text);
//var_dump($script);

for($i=0 ; $i<sizeof($script->node) ; ++$i){
    echo $script->node[$i]->id;
}

//echo('<!doctype html><html><head><meta charset="utf-8"></head><body>');
//echo('<script>console.log('.$text.');</script>');
//echo('</body></html>');
?>

