<?php

class Admin_JsonController extends Coringa_Controller_Admin_Action {

    public function init() {
        $this->noRender();
    }

    public function getMediaAction() {
        $params = $this->getRequest()->getParams();
        $folder_default = $params['folder'] != 'media' ? $params['folder'] : 'media/blog';
        if ($params['type'] == 'img') {
            $fb = str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']);
            $folder = $fb . $folder_default . '/';
            $dir = scandir($folder);
            $x = 0;
            $pastas = array();
            $files = array();
            $ndir = explode("/", $folder_default);
            unset($ndir[count($ndir) - 1]);

            foreach ($dir as $file) {
                if ($file !== '.' && $file !== '..') {
                    if (count($ndir) > 2 && $x == 0) {
                        $pastas[$x]['nome'] = 'voltar';
                        $pastas[$x]['path'] = implode("/", $ndir);
                        $pastas[$x]['real_path'] = $fb;
                        $pastas[$x]['back'] = true;
                        $x++;
                    }
                    if (is_dir($folder . $file)) {

                        $pastas[$x]['nome'] = $file;
                        $pastas[$x]['path'] = str_replace($fb, "", $folder) . $file;
                        $pastas[$x]['real_path'] = $fb . $file;
                        $pastas[$x]['back'] = false;
                        $x++;
                    }
                    else {
                        if (stristr($file, '.jpg') || stristr($file, '.gif') || stristr($file, '.png')) {

                            if (stristr($file, '_thumb')) {
                                $files[$x]['nome'] = $file;
                                $files[$x]['path'] = str_replace($fb, "", $folder) . $file;
                                $files[$x]['real_path'] = str_replace($fb, "", $folder) . str_replace("_thumb", "", $file);
                                $x++;
                            }
                        }
                    }
                }
            }
            $lista = array("folders" => $pastas, "files" => $files);
        }


        echo json_encode($lista);
    }

    public function getGoogleAction() {
        $query = urlencode($this->getRequest()->getParam("query"));
        $qtd = $this->getRequest()->getParam("qtd") + 1;



        for ($x = 1; $x < $qtd * 5; $x++) {
            $json = $this->get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='
                    . str_replace('%20', '+', urlencode($query))
                    . '&rsz=large'
                    . '&start=' . $x
                    . '&safe=moderate'
                    . '&imgsz=xxlarge'
                    . '&as_filetype=jpg'
            );
            $data = json_decode($json);
            foreach ($data->responseData->results as $result) {
                if (!in_array($result->url, $urls)) {
                    $urls[] = $result->url;
                    $results[] = array('real_path' => $result->url, 'title' => $result->title, 'thumb' => $result->tbUrl);
                }
                else {
                    $x - 1;
                }
            }
        }

        echo json_encode($results);
        //print_r($results);
    }

    function get_url_contents($url) {
        $crl = curl_init();

        curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 10);

        $ret = curl_exec($crl);
        curl_close($crl);
        return $ret;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

