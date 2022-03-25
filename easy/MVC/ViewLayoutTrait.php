<?php

namespace easy\MVC;

use easy\Application;
use easy\basic\Router;

trait ViewLayoutTrait
{
    /**
     * @param string $s
     * @return string
     */
    public function escape(string $s): string
    {
        return htmlspecialchars($s);
    }

    /**
     * @param string $name
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function href(string $name, array $params = []): string
    {
        /** @var Router $router */
        $router = Application::$serviceContainer->get(Router::class);
        return $router->route($name, $params);
    }

    /**
     * @param array|null $htmlOptions
     * @return string
     */
    private function linkHtmlOptionsToHtml(?array $htmlOptions): string
    {
        $html = [];
        if ($htmlOptions) {
            foreach ($htmlOptions as $option => $value) {
                $value = $this->escape($value);
                $html[] = " $option=\"$value\"";
            }
        }
        $html = $this->linkHtmlOptionsToHtml($htmlOptions);
        $html = join(' ', $html);
        $html = rtrim($html);
        return $html;
    }

    /**
     * @param string $name
     * @param array $params
     * @param string|null $label
     * @param array|null $htmlOptions
     * @return string
     * @throws \Exception
     */
    public function link(string $name, array $params = [], ?string $label = null, ?array $htmlOptions = []): string
    {
        $label = $label ?: $name;
        $href = $this->href($name, $params);
        $html = $this->linkHtmlOptionsToHtml($htmlOptions);
        $html = "<a href=\"$href\"$html>$label</a>";
        return $html;
    }

    public function partial(string $filename, array $params = [])
    {
        $dir = $this->partialGetDir();
    }

    /**
     * @return string
     */
    private function partialGetDir(): string
    {
        $class = get_class($this);
        if (Layout::class == $class) {
            $dirname = 'app/layouts';
        } elseif (View::class == $class) {
            $dirname = 'app/views';
        }
        return $dirname;
    }
}
