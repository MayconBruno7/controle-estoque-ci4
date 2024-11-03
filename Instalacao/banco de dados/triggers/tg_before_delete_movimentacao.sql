DELIMITER //

CREATE TRIGGER tg_before_delete_movimentacao
BEFORE DELETE ON movimentacao
FOR EACH ROW
BEGIN
    DECLARE v_tipo INT;
    DECLARE v_estoque_atual INT;

    -- Verifica se o tipo da movimentação excluída era 1 (Entrada) ou 2 (Saída)
    SET v_tipo = OLD.tipo;

    -- Verifica a quantidade total de produtos associados à movimentação que está sendo excluída
    IF v_tipo IN (1, 2) THEN
        SELECT SUM(mi.quantidade) INTO v_estoque_atual
        FROM movimentacao_item mi
        WHERE mi.id_movimentacoes = OLD.id;
    END IF;

    -- Atualiza a quantidade de produtos na tabela produto
    UPDATE produto p
    JOIN movimentacao_item mi ON p.id = mi.id_produtos
    SET p.quantidade = CASE
        WHEN v_tipo = 1 THEN p.quantidade - mi.quantidade
        WHEN v_tipo = 2 THEN p.quantidade + mi.quantidade
    END
    WHERE mi.id_movimentacoes = OLD.id;

END //

DELIMITER ;
