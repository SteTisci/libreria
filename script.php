<?php
require_once __DIR__ . '\vendor\autoload.php';
require_once "Database.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbName = $_ENV['DB_NAME'];

$database = new Database($host, $username, $password, $dbName);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $titolo = str_replace(" ", "", $_POST["titolo"]);

    try {
        // Inizializzazione cURL per mandare richiesta GET all'API Google books
        $curlSES = curl_init();

        // Configurazione richiesta, viene passato il titolo come parametro al link
        curl_setopt($curlSES, CURLOPT_URL, "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($titolo));
        curl_setopt($curlSES, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlSES, CURLOPT_HEADER, false);

        // Esecuzione della richiesta
        $result = curl_exec($curlSES);

        // Controllo errori cURL
        if ($result === false) {
            throw new Exception('Errore cURL: ' . curl_error($curlSES));
        }

        // Chiusura cURL
        curl_close($curlSES);

        // Decodifica JSON
        $data = json_decode($result, true);

        // Controlla se sono presenti dati
        if (isset($data['items'][0]['volumeInfo'])) {
            $volumeInfo = $data['items'][0]['volumeInfo'];
            $title = $volumeInfo['title'] ?? 'Titolo non disponibile';
            $authors = implode(', ', $volumeInfo['authors'] ?? ['Autore non disponibile']);
            $publishedDate = $volumeInfo['publishedDate'] ?? 'Data non disponibile';

            // Inserimento dati nel database
            $database->insert($title, $authors, $publishedDate);

        } else {
            throw new Exception("Nessun risultato trovato per il titolo: $titolo");
        }

    } catch (Exception $e) {
        // Gestione eccezioni
        echo 'Errore: ' . $e->getMessage();
    }

    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET["id"])) {
    $database->delete($_GET["id"]);

    header('Location: index.php');
    exit();
}
