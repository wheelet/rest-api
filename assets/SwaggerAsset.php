<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * SwaggerAsset bundle
 * 
 * Registers all required Swagger UI assets
 */
class SwaggerAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';
    
    /**
     * @var string
     */
    public $baseUrl = '@web';
    
    /**
     * @var array
     */
    public $css = [
        'https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui.css',
        'css/swagger/style.css',
    ];
    
    /**
     * @var array
     */
    public $js = [
        'https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui-bundle.js',
        'https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui-standalone-preset.js',
        'js/swagger/interceptors.js',
        'js/swagger/config.js',
    ];
    
    /**
     * @var array
     */
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
    
    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
