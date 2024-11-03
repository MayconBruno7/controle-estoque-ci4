DELIMITER $$;
CREATE TRIGGER `tg_before_update_movimentacao`
BEFORE UPDATE ON `movimentacao`
FOR EACH ROW
BEGIN
    DECLARE v_tipo INT;

    -- Verifica se o tipo da movimentação foi alterado
    IF OLD.tipo != NEW.tipo THEN
        SET v_tipo = OLD.tipo;

        -- Atualiza a quantidade de produtos na tabela produto
        -- Para cada item associado à movimentação excluída
        UPDATE produto p
        JOIN movimentacao_item mi ON p.id = mi.id_produtos
        SET p.quantidade = CASE
            WHEN v_tipo = 1 THEN p.quantidade - mi.quantidade -- Entrada: subtrai a quantidade
            WHEN v_tipo = 2 THEN p.quantidade + mi.quantidade -- Saída: adiciona a quantidade
        END
        WHERE mi.id_movimentacoes = OLD.id;
    END IF;

END $$;
