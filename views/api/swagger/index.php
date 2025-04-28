<?php
/** @var string $restUrl */
use yii\helpers\Html;
use app\assets\SwaggerAsset;

$this->title = 'API Documentation';

SwaggerAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div id="swagger-ui"></div>

    <script>
        window.onload = function() {
            const ui = SwaggerUIBundle(createSwaggerUIConfig("<?= $restUrl ?>"));
            window.ui = ui;
        };
    </script>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
