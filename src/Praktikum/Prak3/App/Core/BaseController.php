<?php
declare(strict_types=1);

abstract class BaseController extends DebugHelper
{
    protected function renderHtml(string $viewFile, array $data = []): void
    {
        header('Content-Type: text/html; charset=UTF-8');

        if (!file_exists($viewFile)) {
            $candidate = __DIR__ . '/../View/' . $viewFile;
            if (file_exists($candidate)) {
                $viewFile = $candidate;
            }
        }

        extract($data);
        require $viewFile;
    }

    protected function renderJson(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    protected function getData()
    {
    }

    protected function processData()
    {
    }

    public function handleRequest(): void
    {
    }

    public function generateResponse(): string
    {
        ob_start();
        $this->processData();
        $this->getData();
        return (string) ob_get_clean();
    }
}
