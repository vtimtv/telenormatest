<?php
define('BASE_DIR', str_replace(DIRECTORY_SEPARATOR,'/', dirname(__FILE__)).'/');

include ('../app/helpers.php');

Use App\Database;

$sql = <<<SQL
select goods.id, goods.name, additional_fields.name param, additional_field_values.name val
from goods
    left join additional_goods_field_values on goods.id = additional_goods_field_values.good_id = additional_goods_field_values.good_id
    left join additional_fields on additional_goods_field_values.additional_field_id = additional_fields.id
    left join additional_field_values on additional_goods_field_values.additional_field_value_id = additional_field_values.id
order by goods.id, additional_fields.id, additional_field_values.id
SQL;

$dbres = Database::exec_query($sql);
$goods = [];
$prevId = null;
foreach($dbres as $good) {
    if(!isset($goods[$good['id']])){
        $goods[$good['id']] = array();
        $goods[$good['id']]['Name'] = $good['name'];
    }
    $goods[$good['id']][$good['param']] = $good['val'];
}

echo '<table>';
foreach($goods as $good){
    echo '<tr>';
    foreach($good as $key => $val){
        echo '<td><small style="color:gray">&nbsp;'.$key.'</small>' . $val. '<td>';
    }
    echo '</tr>';
}
echo '</table>';

?>

