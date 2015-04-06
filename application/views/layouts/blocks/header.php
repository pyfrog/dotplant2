<?php

/**
 * @var $this \yii\web\View
 */

use app\assets\AppAsset;
use app\models\Config;
use kartik\helpers\Html;

AppAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://<?=Config::getValue('core.serverName', Yii::$app->request->serverName)?>">
    <title><?= Html::encode($this->title) ?></title>

    <?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body itemscope itemtype="http://schema.org/WebPage">
<?php $this->beginBody(); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <a href="/" class="logo">DotPlant<sup>2</sup></a>
            </div>
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>

                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Yii::t('app', 'Hello') ?>
                    <strong><?= Html::a(Yii::$app->user->identity->username, ['/cabinet']) ?>!</strong>
                <?php endif; ?>

                <?php if (is_array(Yii::$app->session->get('comparisonProductList')) && count(Yii::$app->session->get('comparisonProductList')) > 0): ?>
                    <?=
                    \kartik\helpers\Html::a(
                        Yii::t(
                            'shop',
                            'Compare products [{count}]',
                            [
                                'count' => count(Yii::$app->session->get('comparisonProductList')),
                            ]
                        ),
                        [
                            '/product-compare/compare',
                        ],
                        [
                            'class' => 'btn',
                        ]
                    )
                    ?>
                <?php endif; ?>

            <?php
                echo \app\widgets\CartInfo::widget()
            ?>

                <?php
                    $form = \yii\widgets\ActiveForm::begin(
                        [
                            'action' => ['/default/search'],
                            'id' => 'search-form',
                            'method' => 'get',
                            'options' => [
                                'class' => 'form-inline navbar-search',
                            ],
                        ]
                    );
                    $model = new \app\models\Search;
                    $model->load(Yii::$app->request->get());
                    echo $form->field(
                        $model,
                        'q',
                        [
                            'options' => [
                                'class' => '',
                                'tag' => 'span',
                            ],
                            'template' => '{input}',
                        ]
                    )->widget(
                        \app\widgets\AutoCompleteSearch::className(),
                        [
                            'options' => [
                                'class' => 'srchTxt',
                                'placeholder' => Yii::t('app', 'Search'),
                            ]
                        ]
                    );
                    echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']);
                    \yii\widgets\ActiveForm::end();
                ?>
                <?=
                    \app\widgets\navigation\NavigationWidget::widget(
                        [
                            'rootId' => 1,
                            'appendItems' => [
                                [
                                    'label' => Yii::$app->user->isGuest
                                        ? Yii::t('app', 'Login')
                                        : Yii::t('app', 'Logout'),
                                    'itemOptions' => [
                                        'class' => 'btn btn-large btn-success',
                                    ],
                                    'url' => Yii::$app->user->isGuest ? '/login' : '/logout',
                                ],
                            ],
                            'options' => [
                                'class' => 'nav pull-right',
                            ],
                        ]
                    )
                ?>
