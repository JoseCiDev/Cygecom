<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PdfGeneratorButton extends Component
{
    /**
     * @abstract Usa-se a biblioteca com <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
     */
    public $printBySelector;
    public $fileName = 'solicitacao';

    public function __construct($printBySelector, $fileName = null)
    {
        $this->printBySelector = $printBySelector;
        $this->fileName = $fileName;
    }

    public function render(): View|Closure|string
    {
        return view('components.pdf-generator-button', ['selector' => $this->printBySelector, 'fileName' => $this->fileName]);
    }
}
