<?php

namespace NgakakSeru\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use NgakakSeru\Database\PostContent;

class Dashboard
{
    private $errorMessage = '';

    public function uploadPicture(Request $request, Application $app)
    {
        // Render a template
        //$data['error'] = $this->errorMessage;
        $data['base_url'] = $request->getBasePath();

        return new Response($app['view']->render('formupload', $data));
    }

    public function uploadPictureDo(Request $request, Application $app)
    {
        $base_url = $request->getBasePath();
        $lokasi_file    = $_FILES['gambar'] ['tmp_name'];
        $nama_file      = uniqid("img-").$_FILES['gambar'] ['name'];

        // var_dump($_FILES);
        //Buat folder

        if (!empty($lokasi_file)) {
            move_uploaded_file($lokasi_file, __DIR__."/../../../web/asset/post_image/$nama_file");

            $judul = $request->get('judul');

            $input = array(
                'user_id' => $_SESSION['user']['user_id'],
                'judul' => $judul,
                'image' => $nama_file,
            );
            $insertPost = new PostContent();
            $cek_insert = $insertPost->insert($app['database'], $input);

            return var_dump($cek_insert);
            $newURL = get_site_url()."dashboard/uploadpicture";
            header('Location: '.$newURL);

            return new Response($app['view']->render('auth', $data));
        }
    }

    public function history(Request $request, Application $app)
    {
        $data = array();

        return new Response($app['view']->render('history', $data));
    }
}
