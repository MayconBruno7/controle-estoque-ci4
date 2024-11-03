<?php

// app/Controllers/FileController.php

namespace App\Controllers;

use CodeIgniter\Controller;

class FileController extends Controller
{
    public function show($filename)
    {
        $path = WRITEPATH . 'uploads/funcionarios/' . $filename;

        // Verifica se o arquivo existe
        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Arquivo não encontrado: $filename");
        }

        // Define os headers corretos para o tipo de arquivo
        $fileInfo = pathinfo($path);
        switch (strtolower($fileInfo['extension'])) {
            case 'jpg':
            case 'jpeg':
                $mimeType = 'image/jpeg';
                break;
            case 'png':
                $mimeType = 'image/png';
                break;
            case 'gif':
                $mimeType = 'image/gif';
                break;
            case 'bmp':
                $mimeType = 'image/bmp';
                break;
            default:
                $mimeType = 'application/octet-stream';
                break;
        }

        // Define os headers
        return $this->response->setHeader('Content-Type', $mimeType)
                              ->setHeader('Content-Length', filesize($path))
                              ->setHeader('Content-Disposition', 'inline; filename="' . $fileInfo['basename'] . '"')
                              ->setBody(readfile($path));
    }
}

