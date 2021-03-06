<?php

/*
 * This file is part of the plusarchive.com
 *
 * (c) Tomoki Morita <tmsongbooks215@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $data
 * @var app\models\search\LabelSearch $search
 */

use app\components\ActionColumn;
use app\models\LabelTag;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Admin Labels - '.app()->name;
?>
<?php Pjax::begin() ?>
    <?= $this->render('/common/nav/admin', [
        'total' => $data->totalCount,
    ]) ?>
    <?= GridView::widget([
        'id' => 'grid-view-label',
        'dataProvider' => $data,
        'filterModel' => $search,
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(h($data->name), h($data->url), [
                        'class' => 'external-link',
                        'rel' => 'noopener',
                        'target' => '_blank',
                    ]);
                },
            ],
            [
                'attribute' => 'country',
                'filter' => array_combine($countries = $search::getCountries(), $countries),
            ],
            [
                'attribute' => 'link',
                'format' => ['snsIconLink', null, custom_domains(), [
                    'rel' => 'noopener',
                    'target' => '_blank',
                ]],
            ],
            [
                'attribute' => 'tag',
                'value' => 'tagValues',
                'filter' => array_combine($tags = LabelTag::getNames()->column(), $tags),
            ],
            'created_at:datetime',
            'updated_at:datetime',
            ['class' => ActionColumn::class],
        ],
    ]) ?>
    <?= $this->render('/common/pagination', ['pagination' => $data->pagination]) ?>
<?php Pjax::end() ?>
