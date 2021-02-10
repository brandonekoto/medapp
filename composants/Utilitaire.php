<?php

namespace composants;

class Utilitaire {
    
    
    static function countDate(String $d1, String $d2 ){
        if(is_null($d2) || strlen($d2) == 0){
            $d2 =  date('Y-m-d H:i:s');
        }
        
        
        
    }

    static function parseDate($Date) {
        $now = time();
        $time = strtotime($Date);
        $unit = 60;
        $days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'
        );
        if (isset($Date)) {
            $passed = $now - $time;
            $mins = $passed / (60);

            if ($mins < 59) {
                $min = 'il y a ' . (int) (floor($mins)) . 'minutes';
                $date = "";
                return ['time' => $min, 'date' => ''];
            } elseif ($mins >= 60) {
                $min = 'Il ya ' . (int) (($mins / 60)) . ' Heures';
                $date = "";
                return ['time' => $min, 'date' => $date];
            } elseif ($passed >= 86400) {
                $date = date('d/m/y', $time);
                $temps = 'Aujourd\'hui à ' . date("H\hi", $time);
                return ['time' => $temps, 'date' => $date];
            } elseif ($mins >= 86400) {

                $day = date('L', $time);
                $date = date('d/m/y', $time);
                $temps = $days[$day] . " à " . date("H\hi", $time);
                return ['time' => $temps, 'date' => $date];
            }

            /* else {
              $date = date("d/m/y", $time);
              $temps = utf8_encode('Aujourd\'hui � ') . date("H\hi", $time);
              return ['time'=>$temps, 'date'=>$date];

              } */
        }
    }

    static function pagination($nPages, $parPage, $url = 'forum.php') {
        $nPages;
        $nPages = ceil($nPages / $parPage);
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $html = '<ul class="pagination">';
        $prev = false;
        $next = false;

        if ($nPages > 1) {
            if ($page > 1) {
                $html .= "<li class=''><a class='page-link' href='" . $url . "&page=";
                $html .= $page - 1;
                $html .= "'>&nbsp;<span class='glyphicon glyphicon-backward'></span> &nbsp;</a></li>";
                $prev = true;
            }
            for ($i = 1; $i < $nPages + 1; $i++) {
                if ($prev === true) {

                    $html .= "<li><a href='" . $url . "&page=";
                    $html .= $i;
                    $html .= "'";
                    if ($page == $i) {
                        $html .= "style='background-color : rgba(200,200,200,.7)'>";
                    } else {
                        $html .= ">";
                    }
                    $html .= $i;
                    $html .= "</a></li>";
                } else {
                    $html .= "<li><a href='" . $url . "&page=";
                    $html .= $i;
                    $html .= "'";
                    if ($page == $i) {
                        $html .= "style='background-color : rgba(240,240,240,.7)'>";
                    } else {
                        $html .= ">";
                    }

                    $html .= $i;
                    $html .= "</a></li>";
                }
            }

            if ($page <= $nPages - 1) {
                $html .= "<li><a  href='" . $url . "&page=";
                $html .= $page + 1;
                $html .= "'>&nbsp;<span class='glyphicon glyphicon-forward'></span>&nbsp;</a></li>";
            }
            echo $html .= '</ul>';
        }
    }

    static function managerMenuBox($menu = '', $cursor = '') {
        if ($menu == "write" && $menu == $cursor) {
            return "block";
        } elseif ($menu = "box" && $menu == $cursor) {
            return "block";
        } elseif ($menu = "boxSys" && $menu == $cursor) {
            return "block";
        } elseif ($menu = "draft" && $menu == $cursor) {
            return "show";
        } elseif ($menu = "spam" && $menu == $cursor) {
            return "block";
        } elseif ($menu = "reading" && $menu == $cursor) {
            return "block";
        } else {
            return "none";
        }
    }

    static function breadCrumb($param) {
        $html = '<ol class="breadcrumb">';
        $i = 0;
        foreach ($param as $k => $v) {
            if ($i === (count($param) - 1)) {
                $html .= "<li>$k</li>";
            } else {
                $html .= "<li><a href='" . $v . "'>$k</a></li>";
            }
            $i++;
        }

        $html .= "</ol>";
        return $html;
    }

    static function search($keyword) {
        $results = array();
        if (isset($keyword) && strlen($keyword) > 0) {

            $user = new users();
            $forum = new Forum();
            $users = array();
            $forums = array();
            $users = $user->search($keyword);
            $forums = $forum->search($keyword);

            if (count($users) > 0) {
                foreach ($users as $usr) {
                    array_push($results, (array) $usr);
                }
            }
            if (count($forums) > 0) {
                foreach ($forums as $item) {
                    array_push($results, (array) $item);
                }
            }


            $html = "";
            if (count($results) > 0) {

                $nResult = count($results);
                foreach ($results as $k => $v) {

                    if (array_key_exists('idforum', $v)) {
                        $html .= "<div class='itemResult'>
                            <div class='auteurInfo'>
                                <a href='/account.php?user=";
                        $html .= $v['auteur_forum'] . "'>
                                <img alt='" . $v['src'] . "' src='img/" . $v['src'] . "." . $v['type'] . "' class='userProfile'>
                                </a>
                            </div>
                            <div class='infoResult'>
                                            <h2><a href='forum.php?view=" . $v['idforum'] . "'>" . self::wrapFoundKeyword($keyword, $v['sujet_forum']) . "</a></h2>
                                            <div class='infoStatResult'>
                                            <a href='" . $_SERVER['SERVER_NAME'] . "/forum.php?view=" . $v['idforum'] . "' class='urlSearch'>" . $_SERVER['SERVER_NAME'] . "/forum.php?view= " . $v['idforum'] . "</a>
                                            <ul>
                                                <li><a href=''><span class='iconePost'><img src='img/icone/Entypo_d83d(0)_24.png'></span>" . $v['date_forum'] . "</a></li>
                                                <li><a href='/forum.php?category=" . $v['id_categorie'] . "'><span class='iconePost'><img src='img/icone/Entypo_e731(0)_24.png'></span>" . $v['libelle_categorie'] . "</a></li>
                                                <li><a href=''><span class='iconePost'><img src='img/icone/form/gris200/Entypo_d83d(52)_24.png'></span>" . $v['noms'] . "</a></li>
                                                <li><a href=''><span class='iconePost'><img src='img/icone/Entypo_e720(1)_24.png'></span>" . $v['nComment'] . "</a></li>
                              				</ul>
                              				
                              			   </div>
                              			<div class='contentExtrait'>
                              				" .
                                utf8_encode(self::wrapFoundKeyword($keyword, $v['contenu']))
                                . "
                              			</div>
                          	</div>
                      			
                      		</div>";
                    } elseif (array_key_exists('id_users', $v)) {
                        $html .= "<div class='itemResult'>
                            <div class='auteurInfo'>
                                <a href='/account.php?user=";
                        $html .= $v['id_users'] . "'>
                                <img alt='" . $v['src'] . "' src='img/" . $v['src'] . "." . $v['type'] . "' class='userProfile'>
                                </a>
                            </div>
                            <div class='infoResult'>

                                            <h2><a href='forum.php?view=" . $v['id_users'] . "'>" . self::wrapFoundKeyword($keyword, $v['noms']) . "</a></h2>";

                        $html .= "<div class='infoStatResult'>
                                            <a href='" . $_SERVER['SERVER_NAME'] . "/account.php?user=" . $v['id_users'] . "' class='urlSearch'>" . $_SERVER['SERVER_NAME'] . "/account.php?user= " . self::wrapFoundKeyword($keyword, $v['id_users']) . "</a>
                                            <ul>";
                        if (strlen($v['adresse']) > 0) {
                            $html .= "<li><a href=''><span class='iconePost'><img src='img/icone/form/gris200/Entypo_e724(31)_24.png'></span>" . $v['adresse'] . "</a></li>";
                        }

                        $html .= "
                                                <li><a href='/account.php?user=" . $v['id_users'] . "'><span class='iconePost'><img src='img/icone/Entypo_e731(0)_24.png'></span>Membre</a></li>
                                                <li><a href=''><span class='iconePost'><img src='img/icone/form/gris200/Entypo_d83d(52)_24.png'></span>" . self::wrapFoundKeyword($keyword, $v['noms']) . "</a></li>
                                                <li><a href=''><span class='iconePost'><img src='img/icone/form/gris200/Entypo_2302(16)_24.png'></span>" . $v['pays'] . "</a></li>
                              				</ul>
                                                    
                              			   </div>
                              			<div class='contentExtrait'>
                              				" .
                                utf8_encode(self::wrapFoundKeyword($keyword, $v['about']))
                                . "
                              			</div>
                          	</div>
                              				    
                      		</div>";
                    }
                }
            } else {
                $html = "<div>" . utf8_encode("Aucune information n'a �t� trouv�e") . "</div>";
            }
        } else {
            $html = "<div>" . utf8_encode("Aucune information n'a �t� trouv�e") . "</div>";
        }
        echo $html;
    }

    static function wrapFoundKeyword($keyword, $text) {
        if (isset($keyword)) {
            $founds = "";
            $keyword = trim($keyword);
            $pattern = "/$keyword/i";

            $founds = preg_replace($pattern, "<span class='foundkeyword'>$keyword</span>", $text);

            return $founds;
        }
    }

    static function ajustImg($index = 1, $len, $tailles = array()) {
        $allAlign = array();
        $tAlign = array(
            'width' => 0,
            'height' => 0,
            'left' => 0,
            'top' => 0
        );
        if (isset($index) && isset($len)) {

            if ($len == 1) {
                $tAlign['width'] = '100%';
                $tAlign['height'] = '100%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '0%';
                array_push($allAlign, $tAlign);
            } elseif ($len == 2) {
                $tAlign['width'] = '100%';
                $tAlign['height'] = '100%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '0%';
                array_push($allAlign, $tAlign);
                $tAlign['width'] = '100%';
                $tAlign['height'] = '50%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '50%';
                array_push($allAlign, $tAlign);
            } elseif ($len == 3) {
                $tAlign['width'] = '100%';
                $tAlign['height'] = '50%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '0%';
                array_push($allAlign, $tAlign);
                $tAlign['width'] = '50%';
                $tAlign['height'] = '50%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '50%';
                array_push($allAlign, $tAlign);
                $tAlign['width'] = '50%';
                $tAlign['height'] = '50%';
                $tAlign['left'] = '50%';
                $tAlign['top'] = '50%';
                array_push($allAlign, $tAlign);
            } elseif ($len == 4) {
                $tAlign['width'] = '50%';
                $tAlign['height'] = '66.666666666%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '0%';
                array_push($allAlign, $tAlign);

                $tAlign['width'] = '50%';
                $tAlign['height'] = '66.666666666%';
                $tAlign['left'] = '50%';
                $tAlign['top'] = '0%';
                //$allAlign[$index] = $tAlign;
                array_push($allAlign, $tAlign);

                $tAlign['width'] = '33.3333333333%';
                $tAlign['height'] = '33.3333333333%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '66.666666666%';
                array_push($allAlign, $tAlign);
                $tAlign['width'] = '33.3333333333%';
                $tAlign['height'] = '33.3333333333%';
                $tAlign['left'] = '33.3333333333%';
                $tAlign['top'] = '66.666666666%';
                array_push($allAlign, $tAlign);
                $tAlign['width'] = '33.3333333333%';
                $tAlign['height'] = '33.3333333333%';
                $tAlign['left'] = '66.666666666%';
                $tAlign['top'] = '66.666666666%';
                array_push($allAlign, $tAlign);
            } elseif ($len > 4) {
                $tAlign['width'] = '50%';
                $tAlign['height'] = '66.666666666%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '0%';
                array_push($allAlign, $tAlign);

                $tAlign['width'] = '50%';
                $tAlign['height'] = '66.666666666%';
                $tAlign['left'] = '50%';
                $tAlign['top'] = '0%';
                //$allAlign[$index] = $tAlign;
                array_push($allAlign, $tAlign);

                $tAlign['width'] = '33.3333333333%';
                $tAlign['height'] = '33.3333333333%';
                $tAlign['left'] = '0%';
                $tAlign['top'] = '66.666666666%';
                array_push($allAlign, $tAlign);
                $tAlign['width'] = '33.3333333333%';
                $tAlign['height'] = '33.3333333333%';
                $tAlign['left'] = '33.3333333333%';
                $tAlign['top'] = '66.666666666%';
                array_push($allAlign, $tAlign);
                $tAlign['width'] = '33.3333333333%';
                $tAlign['height'] = '33.3333333333%';
                $tAlign['left'] = '66.666666666%';
                $tAlign['top'] = '66.666666666%';
                array_push($allAlign, $tAlign);
            }
        }

        return $allAlign;
    }

    public static function translateCharacter($string) {
        $val = "á|â|à|å|ä ð|é|ê|è|ë í|î|ì|ï ó|ô|ò|ø|õ|ö ú|û|ù|ü æ ç ß abc ABC 123";
        return iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    }

    public static function translateInAsciiCode($str) {

        $new = "";
        if (isset($str) && !empty($str)) {
            for ($i = 0; $i < strlen($str); $i++) {
                $new .= ord($str[$i]);
            }
        }
        
        return $new;
    }
    
    public static function debug($datas, $end = false){
        echo "<pre>";
        var_dump($datas);
        echo '</pre>';
        if($end){
            die();
        }
    }
}
