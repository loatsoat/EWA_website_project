<?php
declare(strict_types=1);

require_once 'App/Core/BaseController.php';

class AboutController extends BaseController
{

    /**
     * Generate the full response output.
     * This method may output HTML, JSON, or other formats as needed.
     *
     * @return void
     */
    public function generateResponse(): string {
        ob_start();
        $this->renderHtml('App/View/about.view.php');
        return (string) ob_get_clean();
    }

    /**
     * Handles the request lifecycle for the about page.
     *
     * @return void
     */
    public function handleRequest(): void
    {
        $this->generateResponse();
    }
}
