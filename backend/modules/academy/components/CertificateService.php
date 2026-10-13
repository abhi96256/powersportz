<?php

namespace backend\modules\academy\components;

use Yii;

class CertificateService
{
    public function renderPdfFromHtml($html, $backgroundPath = null, $cssPath = null)
    {
        $format = 'A4';
        if ($backgroundPath && is_file($backgroundPath)) {
            $imageSize = @getimagesize($backgroundPath);
            if (is_array($imageSize) && isset($imageSize[0], $imageSize[1]) && $imageSize[0] > 0) {
                $ratio = $imageSize[1] / $imageSize[0];
                $format = [210, 210 * $ratio];
            }
        }

        // Font configuration
        $fontDir = Yii::getAlias('@backend') . '/web/fonts';
        $fontFile = $fontDir . '/Italianno-Regular.ttf';
        
        $customFontConfig = [
            'fontdata' => [
                'italianno' => [
                    'R' => 'Italianno-Regular.ttf',
                ],
            ],
        ];

        // mPDF Class Loading Resilience
        if (!class_exists('\\Mpdf\\Mpdf') && !class_exists('mPDF')) {
            $vendorDir = Yii::getAlias('@vendor');
            $manualPaths = [
                $vendorDir . '/tedivm/mpdf/mpdf/mpdf.php',
                $vendorDir . '/mpdf/mpdf.php',
                $vendorDir . '/mpdf/mpdf/mpdf.php',
            ];
            foreach ($manualPaths as $path) {
                if (is_file($path)) {
                    require_once($path);
                    break;
                }
            }
        }

        // Ensure temp directory for mPDF exists and is writable
        $tempDir = Yii::getAlias('@runtime') . '/mpdf';
        if (!is_dir($tempDir)) {
            @mkdir($tempDir, 0777, true);
        }

        if (class_exists('\\Mpdf\\Mpdf')) {
            // mPDF 7.x+ logic
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'format' => $format,
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
                'fontDir' => array_merge($fontDirs, [$fontDir]),
                'fontdata' => array_merge($fontData, $customFontConfig['fontdata']),
                'default_font' => 'dejavusans',
                'tempDir' => $tempDir, 
            ]);
        } elseif (class_exists('mPDF') || class_exists('\\mPDF')) {
            $mpdf = new \mPDF('', $format, 0, '', 0, 0, 0, 0, 0, 0);
            
            if (property_exists($mpdf, 'tempDir')) {
                $mpdf->tempDir = $tempDir;
            }

            $mpdf->fontDir[] = $fontDir;

            foreach ($customFontConfig['fontdata'] as $f => $fs) {
                $mpdf->fontdata[$f] = $fs;
            }
            
            $mpdf->allow_charset_conversion = true;
            $mpdf->charset_in = 'UTF-8';
        } else {
            throw new \RuntimeException('mPDF library could not be found or loaded.');
        }

        if ($backgroundPath && is_file($backgroundPath)) {
            if (method_exists($mpdf, 'SetWatermarkImage')) {
                $mpdf->SetWatermarkImage($backgroundPath, 1, 'F');
                $mpdf->showWatermarkImage = true;
                if (property_exists($mpdf, 'watermarkImgBehind')) {
                    $mpdf->watermarkImgBehind = true;
                }
            }
        }

        if ($cssPath && is_file($cssPath)) {
            $css = file_get_contents($cssPath);
            if ($css !== false) {
                $mpdf->WriteHTML($css, 1);
            }
        }

        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S');
    }
}
