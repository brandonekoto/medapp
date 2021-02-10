<?php
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        if(isset($_GET['mod']) && !empty($_GET['mod'])){
            $file = "controls" . "\\" . ucfirst($_GET['mod']);
            try{
                $mod = new $file();
                if(isset($_GET['act']) && !empty($_GET['act'])){
                    $action = $_GET['act'];
                    if(method_exists($mod, $action)){
                        unset($_GET['act'] );
                        unset($_GET['mod'] );
                        if(is_array($_GET) && count($_GET)>0){                        
                            echo json_encode($mod->$action($_GET));
                        }else{
                            echo json_encode($mod->$action());
                        }
                    }else{
                        throw new \composants\MDEException("cette page n'existe pas, soit elle a été déplacée ou supprimée");  
                    }
                }else{
                    
                }
            } catch (Exception $ex) {
                throw new \composants\MDEException($ex);        
            }
        }else{

        }
        
    }else{
        if(isset($_GET['mod']) && !empty($_GET['mod'])){
            $file = "controls" . "\\" . ucfirst($_GET['mod']);
            try{
                $mod = new $file();
                if(isset($_GET['act']) && !empty($_GET['act'])){
                    $action = $_GET['act'];
                    if(method_exists($mod, $action)){              
                        unset($_GET['act'] );
                        unset($_GET['mod'] );
                        if(is_array($_GET) && count($_GET)>0){                        
                            $mod->$action($_GET);
                        }else{
                            $mod->$action();
                        }
                    }else{
                        throw new \composants\MDEException("cette page n'existe pas, soit elle a été déplacée ou supprimée", 401);     
                        
                    }
                }else{
                    throw new \composants\MDEException("Aucune action ou page n'a été sélectionnée. Si l'erreur persiste prière de contacter l'administrateur du système", 401);  
                }
            } catch (\composants\MDEException $ex) {               
                //throw new \composants\MDEException($ex); 
            }
        }else{
             throw new \composants\MDEException("Aucun module n'est sélectionné");
        }
    }