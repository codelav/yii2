<?php
declare(strict_types=1);

namespace app\modules\history\controllers;

use app\core\database\provider\RepositoryDataProvider;
use app\core\router\services\PaginationDataMapper;
use app\modules\history\services\HistoryManager;
use Throwable;
use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Request;

class HistoryController extends Controller
{
    private $historyManager;
    private $historyPaginationDataMapper;
    private $request;

    public function __construct(
        string $id,
        Module $module,
        HistoryManager $historyManager,
        PaginationDataMapper $historyPaginationDataMapper,
        Request $request,
        array $config = []
    ) {
        $this->historyManager = $historyManager;
        $this->historyPaginationDataMapper = $historyPaginationDataMapper;
        $this->request = $request;

        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $paginationData = $this->historyPaginationDataMapper->mapToNormalizedData($this->request->queryParams);
        $historyData = $this->historyManager->getHistory($paginationData);

        return $this->render('index', [
            'dataProvider' => $historyData,
            'linkExport' => Url::to('/history/history/export')
        ]);
    }

    public function actionExport(): void
    {
        header('Content-type: application/csv');
        header(sprintf('Content-Disposition: attachment; filename=%s.csv', 'history-' . time()));

        $handle = fopen( 'php://output', 'wb');

        try {
            $this->historyManager->exportCsv($handle);
        } catch (Throwable $e) {
            Yii::error('[History] Export failed: ' . $e->getMessage());
        } finally {
            fclose($handle);
            exit();
        }
    }
}
