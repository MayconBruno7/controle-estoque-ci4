DELIMITER $$

CREATE TRIGGER after_update_produto_historico
AFTER UPDATE ON produto
FOR EACH ROW
BEGIN
    INSERT INTO historico_produto (
        id_produtos,
        fornecedor_id,
        nome_produtos,
        descricao_anterior,
        quantidade_anterior,
        status_anterior,
        statusItem_anterior,
        dataMod
    )
    VALUES (
        OLD.id,               -- ID do produto atualizado
        OLD.fornecedor,       -- Fornecedor anterior
        OLD.nome,             -- Nome do produto anterior
        OLD.descricao,        -- Descrição anterior
        0,                    -- Quantidade anterior (ajustar se aplicável)
        OLD.statusRegistro,   -- Status anterior
        OLD.condicao,         -- Condição anterior
        NOW()                 -- Data da modificação
    );
END$$

DELIMITER ;
