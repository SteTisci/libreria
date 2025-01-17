<?php
class Database
{
    private $conn;

    public function __construct($servername, $username, $password, $dbName)
    {
        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function insert($titolo, $autore, $anno_pubblicazione, $imgURL)
    {
        try {
            $sql = "INSERT INTO libri (titolo, autore, anno_pubblicazione, img) VALUES (:titolo, :autore, :anno_pubblicazione, :img)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':titolo', $titolo);
            $stmt->bindParam(':autore', $autore);
            $stmt->bindParam(':anno_pubblicazione', $anno_pubblicazione);
            $stmt->bindParam(':img', $imgURL);
            $stmt->execute();

        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    public function select()
    {
        $sql = "SELECT id, titolo, autore, anno_pubblicazione, img FROM libri";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $data[] = $row;
        }

        if (!empty($data)) {
            return $data;
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM libri Where id=$id";
            $this->conn->exec($sql);
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    public function close()
    {
        $this->conn = null;
    }
}