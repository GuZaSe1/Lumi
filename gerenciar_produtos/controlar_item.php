<?php
require '../db.php';

$acao = $_POST['acao'] ?? '';

if ($acao === 'listar') {
    $queryListar = "SELECT cod_item, 
                           den_item,    
                           qtd_estoque, 
                           preco_item, 
                           imagem_item
                      FROM item
                  ORDER BY cod_item";

    $exe_listar = $pdo->query($queryListar);
    $row_listar = $exe_listar->fetchAll(PDO::FETCH_ASSOC);

    var_dump($row_listar);

    echo json_encode($row_listar);
    exit;
}

if ($acao === 'inserir') {
    $queryInserir = "INSERT INTO item (den_item, qtd_estoque, preco_item, imagem_item)
                          VALUES (:den_item, :qtd_estoque, :preco_item, :imagem_item)";

    $exe_inserir = $pdo->prepare($queryInserir);
    $exe_inserir->execute([
        ':den_item'     => $_POST['den_item'],
        ':qtd_estoque'  => $_POST['qtd_estoque'],
        ':preco_item'   => $_POST['preco_item'],
        ':imagem_item'  => $_POST['imagem_item'] ?? null
    ]);

    echo json_encode(['success' => true, 'message' => 'Item inserido com sucesso.']);
    exit;
}

if ($acao === 'atualizar') {
    $queryUpdate = "UPDATE item 
                       SET den_item = :den_item,
                           qtd_estoque = :qtd_estoque,
                           preco_item = :preco_item,
                           imagem_item = :imagem_item
                     WHERE cod_item = :cod_item";

    $exe_update = $pdo->prepare($queryUpdate);
    $exe_update->execute([
        ':den_item'     => $_POST['den_item'],
        ':qtd_estoque'  => $_POST['qtd_estoque'],
        ':preco_item'   => $_POST['preco_item'],
        ':imagem_item'  => $_POST['imagem_item'] ?? null,
        ':cod_item'     => $_POST['cod_item']
    ]);

    echo json_encode(['success' => true, 'message' => 'Item atualizado com sucesso.']);
    exit;
}

echo json_encode(['error' => true, 'message' => 'Ação inválida ou não informada.']);

// 
