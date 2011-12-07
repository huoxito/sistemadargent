<?php

    class FileUploadComponent extends Component {

        var $name = 'FileUploadComponent';
        
        
        function criaNome($arquivo, $controller){
            
            // Gera um nome automatico para a imagem
            //$temp = substr(md5(uniqid($time)), 0, 10);
            $temp = substr(md5(uniqid(time())), 0, 10);
            $imagem_nome = $temp . ".jpg";
            
            $diretorio = IMAGES.strtolower($controller);  
            // Verifica se o arquivo ja existe, caso positivo, chama essa funcao novamente
            if(file_exists($diretorio . $imagem_nome))
            {
                $imagem_nome = nome($arquivo, $controller);
            }
            return $imagem_nome;
        }
        
        function moveArquivo($tmp_name, $nome, $controller){
            
            $path = IMAGES.strtolower($controller);
            
            if(!file_exists($path)){
                mkdir($path);
                chmod($path, 0777);
            }
            
            if (move_uploaded_file($tmp_name, $path.$nome))
            {
                
                ##################################      BY RUPERT BRASIL LUSTOSA   ####################################################################
                # SCRIPT DE GERAÇÃO DAS THUMB ( SCRIPT RECORTA AS FOTOS DAS MARGENS AO CENTRO E FORMA UMA THUMB PROPORCIONAL )
                //$path = $path;   
                $nomeFoto = $nome;
                
                $filename = $path.$nomeFoto;
                
                $width = 70;        # PASSO A LARGURA DA THUMB
                $height = 70;       # PASSO A ALTURA DA THUMB
                $src_x = 0;
                $src_y = 0;
                
                // Get new dimensions
                list($width_orig, $height_orig) = getimagesize($filename);
                $width_temp = $width_orig;
                $height_temp = $height_orig;
                
                
                if($width_orig<$height_orig)
                {
                    $width_temp = ($height_temp*$width)/$height;
                    $width_temp = ceil($width_temp);
                        
                    $src_x = ($width_orig-$width_temp)/2;
                    $src_x = ceil($src_x);
                    
                    if($width_temp>$width_orig)
                    {
                        // vou ter que variar o height_temp e o width_temp senão a imagem terá uma altura preta
                        $height_temp = ($width_orig*$height)/$width;
                        $height_temp = ceil($height_temp);
                        
                        $width_temp = $width_orig;
                        
                        $src_y = $height_orig-$height_temp;
                        $src_y = ceil($src_y/2);
                        
                        $src_x = 0;
                    }
                }
                else if($height_orig<$width_orig)
                {
                    $height_temp = ($width_temp*$height)/$width;
                    $height_temp = ceil($height_temp);
                        
                    $src_y = ($height_orig-$height_temp)/2;
                    $src_y = ceil($src_y);
                    
                    if($height_temp>$height_orig)
                    {
                        // vou ter que variar o width_temp e o height_temp senão a imagem terá uma altura preta
                        $width_temp = ($height_orig*$width)/$height;
                        $width_temp = ceil($width_temp);
                        
                        $height_temp = $height_orig;
                        
                        $src_x = $width_orig-$width_temp;
                        $src_x = ceil($src_x/2);
                        
                        $src_y = 0;
                    }
                }
                
                $dst_x = 0;
                $dst_y = 0;
                
                $image_p = imagecreatetruecolor($width, $height);
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $width_temp, $height_temp);
                
                //imagejpeg($image_p, $path.$nomeFoto, 80);       # GERO A IMAGEM
    
                ##################################      BY RUPERT BRASIL LUSTOSA   ####################################################################
                
                //chmod($path.$nomeFoto, 0777);
                
                if(imagejpeg($image_p, $path.$nomeFoto, 80) && chmod($path.$nomeFoto, 0777))
                    return true;
                else
                    return false;
                
            }else{
                echo 'error'; exit;
            }
            
        }
        
    }


?>