<?php
declare(strict_types=1);

namespace app\modules\history\services;

use app\modules\history\renderers\DefaultRenderer;

class HistoryEventRendererResolver
{
    private const RENDERER_NAMESPACE = '\app\modules\history\renderers\\';

    private const RENDERER_NAME_SUFFIX = 'Renderer';

    private const DEFAULT_RENDERER = DefaultRenderer::class;

    public function get(string $eventName): HistoryEventRendererInterface
    {
        $className = $this->eventNameToClassName($eventName) . self::RENDERER_NAME_SUFFIX;

        $class = class_exists(self::RENDERER_NAMESPACE . $className)
            ? self::RENDERER_NAMESPACE . $className
            : self::DEFAULT_RENDERER
        ;

        return new $class;
    }

    private function eventNameToClassName(string $eventName): string
    {
        return str_replace('_', '', ucwords($eventName));
    }
}
