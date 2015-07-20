<?php

/**
 * @var app\components\WebView $this
 * @var boolean $isInSidebar
 * @var boolean $hideEmpty
 * @var array $filtersArray
 * @var boolean $displayHeader
 * @var string $header
 * @var string $id
 * @var array $urlParams
 * @var bool $usePjax
*/

use yii\helpers\Html;
use yii\helpers\Url;

$sidebarClass = $isInSidebar ? 'sidebar-widget' : '';
if ($usePjax) {
    $this->registerJs("$('#{$id}').dotPlantSmartFilters();");
}

?>

<div class="filter-sets-widget <?= $sidebarClass ?>">
    <?php if ($displayHeader === true): ?>
        <div class="widget-header">
            <?= $header ?>
        </div>
    <?php endif; ?>
    <div class="filters" id="<?=$id?>">
        <?=
        Html::beginForm(
            ['@category', 'last_category_id' => $urlParams['last_category_id']],
            'post',
            [
                'class' => 'filter-form',
            ]
        )
        ?>
            <?php foreach ($filtersArray as $filter): ?>
            <div class="filter-property">
                <?php if ($filter['isRange']): ?>
                    <?=
                    \app\modules\shop\widgets\PropertiesSliderRangeWidget::widget(
                        [
                            'property' => $filter['property'],
                            'categoryId' => $urlParams['last_category_id'],
                            'maxValue' => $filter['max'],
                            'minValue' => $filter['min'],
                            'step' => $filter['step'],
                        ]
                    )
                    ?>
                <?php else: ?>
                    <div class="property-name"><?= Html::encode($filter['name']) ?></div>
                    <ul class="property-values">
                        <?php foreach ($filter['selections'] as $selection): ?>
                        <li>
                            <?=
                            Html::checkbox(
                                'properties[' . $filter['id'] . '][]',
                                $selection['checked'],
                                [
                                    'value' => $selection['id'],
                                    'class' => 'filter-check filter-check-property-' . $filter['id'],
                                    'id' => 'filter-check-' . $selection['id'],
                                    'data-property-id' => $filter['id'],
                                ]
                            )
                            ?>
                            <?=
                            Html::a(
                                $selection['label'],
                                $selection['url'],
                                [
                                    'class' => 'filter-link',
                                    'data-selection-id' => $selection['id'],
                                    'data-property-id' => $filter['id'],
                                ]
                            )
                            ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <div class="filter-actions">
                <?=
                Html::submitButton(
                    Yii::t('app', 'Show'),
                    [
                        'class' => 'btn btn-primary btn-filter-show',
                    ]
                )
                ?>
            </div>
        <?= Html::endForm() ?>
        <div class="overlay"></div>
    </div>
</div>
