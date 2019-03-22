<?php
use yii\helpers\Html;
?>
<td>
    <?= $form->field($size, 'size')->textInput([
        'id' => "ProductSize_{$key}_size",
        'name' => "ProductSize[$key][size]",
    ])->label(false) ?>
</td>
<td>
    <?= $form->field($size, 'count')->textInput([
        'id' => "ProductSize_{$key}_count",
        'name' => "ProductSize[$key][count]",
    ])->label(false) ?>
</td>
<td>
    <?= Html::a('Удалить ', 'javascript:void(0);', [
        'class' => 'product-remove-size-button btn btn-default btn-xs',
    ]) ?>
</td>