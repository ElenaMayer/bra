<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class ContactAsset extends AssetBundle
{
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
    public $js = [
        'http://maps.googleapis.com/maps/api/js?key=AIzaSyAEJgte17bKvMyyWXo1JcWbzsl9Qy-3-uo',
        'js/google-map-custom.js?6',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}