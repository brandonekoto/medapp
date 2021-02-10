<?php
/**
 * Created by PhpStorm.
 * User: Marndine
 * Date: 12/03/2018
 * Time: 05:35
 */

namespace Core\composants;
use Core\model;

class img extends model\modelBase
{
    private $ids = array();
    private $name;
    private $author;
    private $dateCreation;
    private $categorie;
    private $type;
    public $images = null;
    public static $imageFormat = array('jpeg','jpg','png', 'bmp', 'gif');
    public $error = array() ;

    public function __construct($host = "127.0.0.1", $usr = 'root', $pwd = '', $dbName = 'bw', array $params = array(), $provider = "mysql:host=")
    {
        parent::__construct($host, $usr, $pwd, $dbName, $params, $provider);
    }

    public function addImages(array $file, $id_author, $categorie){
        if (isset($file) and isset($file['fImages']) and isset($file['fImages']['name']) ){
            foreach ($file['fImages']['name'] as $k=>$v){
                if ($file['fImages']['error'][$k] === 0){
                    $this->name = "img".time() * 1000 . "." .explode('/' ,$file['fImages']['type'][$k])[1];
                    $this->type = $file['fImages']['type'][$k];
                    $this->author = (int)$_SESSION['users']['id'];
                    $this->categorie = $categorie;
                    if (in_array(explode('/' ,$file['fImages']['type'][$k])[1], self::$imageFormat)){
                        $params = array(
                            'nom' => $this->name,
                            'type' => $this->type,
                            'categorie'=> $categorie,
                            'id_author' => $this->author
                        );
                        $data =  new \stdClass();
                        foreach ($params as $field=>$value){
                            $data->$field = $value;
                        }
                        $r = $this->input($data, 'images');
                        $this->ids[] = $r;
                        move_uploaded_file($file['fImages']['tmp_name'][$k], APP."img/$this->name");
                    }else{
                        $this->error['msg'] = htmlentities("On n'accepte pas ce format en guise de sécurité. Votre image doit avoir les formats suivant :', ',". implode(', ',self::$imageFormat));
                        $this->error['img'] = $file['fImages']['tmp_name'][$k];
                        return false;
                    }
                }else{
                    $this->error['msg'] = htmlentities("Une erreur est surgie lors du téléchargement de l'image $v");
                    $this->error['img'] = $file['fImages']['tmp_name'][$k];
                    return false;
                }
            }
            $this->ids = serialize($this->ids);
            return [$this->ids, $this->error];
        }else{

            return false;
        }
    }
    public function addProfile($file, $id_author){
        if (isset($file['selectImageProfile']) and  !empty($file['selectImageProfile'])){
            $file = $file['selectImageProfile'];

                if (!empty($file['name']) and $file['error'] == 0){
                        $this->name = "img".time() * 1000 . "." .explode('/' ,$file['type'] )[1];
                        $this->type = explode('/' ,$file['type'] )[1];
                        $this->author = (int)$_SESSION['users']['id'];
                        $this->categorie = 'Profile';
                        if (in_array($this->type, self::$imageFormat)){
                            $params = array(
                                'nom' => $this->name,
                                'type' => $file['type'],
                                'categorie'=> 'Profile',
                                'id_author' => $this->author);
                            $data =  new \stdClass();
                            foreach ($params as $field=>$value){
                                $data->$field = $value;
                            }
                            $r = $this->input($data, 'images');
                            $this->ids = $r;
                            if (move_uploaded_file($file['tmp_name'], APP."img/$this->name")){
                                return $this->ids;
                            }else{
                                $this->error['msg'] = htmlentities('Erreur de téléchargement');
                                return $this->error;
                            }

                        }else{
                        $this->error['msg'] = htmlentities("On n'accepte pas ce format en guise de sécurité.
                        Votre image doit avoir les formats suivant :', '," . implode(', ', self::$imageFormat));
                        $this->error['img'] = $file['name'];
                        return false;
                        }
                    }else {
                    $this->error['msg'] = htmlentities("Une erreur est surgie lors du téléchargement de l'image");
                    $this->error['img'] = $file['name'];
                    return false;
                }
    }else{
            return false;
        }
    }

    public function getImage(array $cond = null){
        if (isset($cond) and !empty($cond) and !is_null($cond)){
            $img = $this->get('images',$cond);
            if (!is_bool($img) OR !is_null($img)){
                $img = $img[0];
                if (strstr($img->typeImg, 'jpeg')){
                    $image = imagecreatefromjpeg(APP."img".DS ."$img->nomImg");
                    imagejpeg($image, "images/tmp/$img->nomImg");
                    imagedestroy($image);
                    return $img->nomImg;
                }elseif (strstr($img->typeImg, 'png')){
                    $image = imagecreatefrompng(APP."img".DS ."$img->nomImg");
                     imagepng("images/tmp/$image->nomImg");
                    imagedestroy($image);
                    return $img->nomImg ;
                }elseif (strstr($img->typeImg, 'gif')){
                    $image = imagecreatefromgif(APP."img" . DS. "$img->nomImg");
                    imagegif("images/tmp/$image->nomImg");
                    imagedestroy($image);
                    return $img->nomImg;
                }elseif (strstr($img->typeImg, 'bmp')){
                    $image = imagecreatefromwbmp(APP."img".DS."$img->nomImg");
                    imagewbmp("images/tmp/$image->nomImg");
                    imagedestroy($image);
                    return $img->nomImg;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function checkImage($tmp){

    }
    public function delete($id, $table = null){

    }
    public function rezide($id){

    }



}