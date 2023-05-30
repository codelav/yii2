<?php
declare(strict_types=1);

namespace app\modules\history;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->getUrlManager()->addRules([
            '' => 'history/history/index',
            'export' => 'history/history/export',
        ]);

        Yii::configure($this, require __DIR__ . '/config/config.php');
    }
}
