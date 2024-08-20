<?php
class PesquisaOngsModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function pesquisarOngs($nome_fantasia = null, $endereco = null, $estado = null) {
        $sql = "SELECT * FROM ongs WHERE 1=1";
        $params = [];

        if (!empty($nome_fantasia)) {
            $sql .= " AND nome_fantasia LIKE :nome_fantasia";
            $params[':nome'] = '%' . $nome_fantasia . '%';
        }

        if (!empty($endereco)) {
            $sql .= " AND endereco LIKE :endereco";
            $params[':endereco'] = '%' . $endereco . '%';
        }

        if (!empty($estado)) {
            $sql .= " AND estado LIKE :estado";
            $params[':estado'] = '%' . $estado . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
