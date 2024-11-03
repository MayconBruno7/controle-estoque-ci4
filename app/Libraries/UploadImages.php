<?php 

namespace App\Libraries;

class UploadImages
{
    public static function upload($arquivo, $pasta, $nomeImagem = '')
    {
        $tiposPermitidos = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png', 'image/bmp'];
        $tamanhoPermitido = 500 * 1024; // 500 KB

        $arqName = rand(0, getrandmax()) . "_" . $arquivo['imagem']["name"];
        $arqTemp = $arquivo['imagem']['tmp_name'];

        $uploadPath = WRITEPATH . "uploads/$pasta/"; // Define o caminho para writable/uploads/pasta

        // Cria a pasta se ela não existir
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($arquivo['imagem']['error'] == 0) {
            if (!in_array($arquivo['imagem']['type'], $tiposPermitidos)) {
                session()->set("msgError", "O tipo de arquivo enviado é inválido! ($arqName)");
                return false;
            } else if ($arquivo['imagem']['size'] > $tamanhoPermitido) {
                session()->set("msgError", "O tamanho do arquivo enviado é maior que o limite! ($arqName)");
                return false;
            } else {
                if (!empty($nomeImagem) && file_exists($uploadPath . $nomeImagem)) {
                    unlink($uploadPath . $nomeImagem);
                }
                
                if (move_uploaded_file($arqTemp, $uploadPath . $arqName)) {
                    return $arqName;
                } else {
                    session()->set("msgError", "Erro ao mover o arquivo para a pasta de destino.");
                    return false;
                }
            }
        } else {
            session()->set("msgError", "Erro no upload do arquivo.");
            return false;
        }
    }

    public static function delete($nomeImagem, $pasta)
    {
        $uploadPath = WRITEPATH . "uploads/$pasta/";
        if (file_exists($uploadPath . $nomeImagem)) {
            unlink($uploadPath . $nomeImagem);
        }
    }
}