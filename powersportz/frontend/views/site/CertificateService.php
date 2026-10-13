<?php

namespace frontend\components;

class CertificateService
{
    /**
     * Original function backup as requested by user.
     */
    public function renderPdfFromHtml_v1($html, $backgroundPath = null, $cssPath = null)
    {
        $format = 'A4';
        if ($backgroundPath && is_file($backgroundPath)) {
            $imageSize = @getimagesize($backgroundPath);
            if (is_array($imageSize) && isset($imageSize[0], $imageSize[1]) && $imageSize[0] > 0) {
                $ratio = $imageSize[1] / $imageSize[0];
                $format = [210, 210 * $ratio];
            }
        }

        if (class_exists('\\Mpdf\\Mpdf')) {
            $mpdf = new \Mpdf\Mpdf([
                'format' => $format,
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
                'default_font' => 'dejavusans',
            ]);
        } elseif (class_exists('mPDF')) {
            // mPDF 6.x (PHP 5.5 compatible) uses the mPDF class without namespaces.
            $mpdf = new \mPDF('', $format, 0, 'dejavusans', 0, 0, 0, 0, 0, 0);
        } else {
            throw new \RuntimeException('mPDF is not installed.');
        }

        if ($backgroundPath && is_file($backgroundPath)) {
            // Draw the background image behind the text.
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
                $cssMode = class_exists('\\Mpdf\\HTMLParserMode')
                    ? \Mpdf\HTMLParserMode::HEADER_CSS
                    : 1;
                $mpdf->WriteHTML($css, $cssMode);

                if (stripos($html, '<head>') !== false) {
                    $html = preg_replace('~<head>~i', '<head><style>' . $css . '</style>', $html, 1);
                } else {
                    $html = '<style>' . $css . '</style>' . $html;
                }
            }
        }

        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S');
    }

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
        $fontDir = \Yii::getAlias('@webroot') . '/fonts';
        $fontFile = $fontDir . '/Italianno-Regular.ttf';
        
        // Final sanity check for font file existence
        if (!is_file($fontFile)) {
            // Fallback to absolute path from basePath if webroot alias is problematic
            $fontDir = \Yii::$app->basePath . '/web/fonts';
            $fontFile = $fontDir . '/Italianno-Regular.ttf';
        }

        $customFontConfig = [
            'fontdata' => [
                'italianno' => [
                    'R' => 'Italianno-Regular.ttf',
                ],
            ],
        ];

        // mPDF Class Loading Resilience
        if (!class_exists('\\Mpdf\\Mpdf') && !class_exists('mPDF')) {
            $vendorDir = \Yii::getAlias('@vendor');
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
        $tempDir = \Yii::getAlias('@runtime') . '/mpdf';
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
                'tempDir' => $tempDir, // Explicitly set temp directory
            ]);
        } elseif (class_exists('mPDF') || class_exists('\\mPDF')) {
            // mPDF 6.x registration (PHP 5.5 compatible)
            // Note: mPDF 6 constructor params: mode, format, default_font_size, default_font, mgl, mgr, mgt, mgb, mgh, mgb, orientation
            $mpdf = new \mPDF('', $format, 0, '', 0, 0, 0, 0, 0, 0);
            
            // Set temporary path for mPDF 6.x
            if (property_exists($mpdf, 'tempDir')) {
                $mpdf->tempDir = $tempDir;
            }

            // mPDF 6.x requires adding the directory to fontDir and definition to fontdata
            $mpdf->fontDir[] = $fontDir;

            // Register Italianno in fontdata
            foreach ($customFontConfig['fontdata'] as $f => $fs) {
                $mpdf->fontdata[$f] = $fs;
            }
            
            // For mPDF 6, sometimes we need to set this to true to allow embedding
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
                $cssMode = class_exists('\\Mpdf\\HTMLParserMode')
                    ? \Mpdf\HTMLParserMode::HEADER_CSS
                    : 1;
                $mpdf->WriteHTML($css, $cssMode);

                if (stripos($html, '<head>') !== false) {
                    $html = preg_replace('~<head>~i', '<head><style>' . $css . '</style>', $html, 1);
                } else {
                    $html = '<style>' . $css . '</style>' . $html;
                }
            }
        }

        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S');
    }
}
