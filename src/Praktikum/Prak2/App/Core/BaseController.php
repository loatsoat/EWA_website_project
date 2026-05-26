<?php
declare(strict_types=1);

abstract class BaseController extends DebugHelper
{
    /**
     * Render a PHP view file. If a relative view filename is provided,
     * the method will resolve it inside the App/View directory.
     *
     * @param string $viewFile
     * @param array $viewData
     * @return void
     */
    protected function renderHtml(string $viewFile, array $viewData = []): void
    {
        header('Content-Type: text/html; charset=UTF-8');

        // Resolve relative view paths to the App/View folder
        if (!file_exists($viewFile)) {
            $candidate = __DIR__ . '/../View/' . $viewFile;
            if (file_exists($candidate)) {
                $viewFile = $candidate;
            }
        }

        extract($viewData);
        require $viewFile;
    }

    /**
     * Return JSON response
     *
     * @param mixed $data
     * @return void
     */
    protected function renderJson(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Hooks that controllers can implement. Use protected so children may
    // override them with a compatible visibility and return type.
    protected function getData()
    {
    }

    protected function processData()
    {
    }

    /**
     * Convenience method used by the front controller to produce the full HTML
     * response. It calls the controller hooks and returns the buffered output.
     *
     * @return string
     */
    public function generateResponse(): string
    {
        ob_start();
        $this->processData();
        $this->getData();
        // Child controllers should call renderHtml() themselves
        return (string) ob_get_clean();
    }
}
