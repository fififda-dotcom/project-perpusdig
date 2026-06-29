<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Check if POST request exceeded post_max_size
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
            // Clean output buffer if there's any warning printed by PHP
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            // Display beautiful error page
            echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ukuran Berkas Melebihi Batas - PawLib</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: \'Quicksand\', sans-serif;
            background-color: #fcf9f6;
            color: #4a3c31;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .error-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(74, 60, 49, 0.08);
            border: 2px solid #ebd5c5;
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes popIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .icon-container {
            font-size: 64px;
            color: #e07a5f;
            margin-bottom: 20px;
            display: inline-block;
            position: relative;
        }
        .icon-container i.fa-cat {
            font-size: 72px;
            color: #d4a373;
        }
        .icon-container i.fa-triangle-exclamation {
            position: absolute;
            bottom: -5px;
            right: -10px;
            font-size: 28px;
            color: #e07a5f;
            background: white;
            border-radius: 50%;
            padding: 2px;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            color: #2e2118;
            margin: 0 0 15px 0;
        }
        p {
            font-size: 15px;
            line-height: 1.6;
            color: #8c7b70;
            margin: 0 0 30px 0;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: #4a90e2;
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.2);
        }
        .btn-back:hover {
            background-color: #357abd;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.3);
        }
        .btn-back:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="icon-container">
            <i class="fas fa-cat"></i>
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <h1>Unggahan Terlalu Besar! 😿</h1>
        <p>Ukuran berkas yang Anda unggah melebihi batas maksimal server (40 MB). Silakan perkecil ukuran berkas Anda sebelum mengunggah kembali.</p>
        <button onclick="history.back()" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Halaman Sebelumnya
        </button>
    </div>
</body>
</html>';
            exit;
        }

        // Preload any models, libraries, etc, here.
        if (!headers_sent()) {
            $this->session = \Config\Services::session();
        }
    }
}
