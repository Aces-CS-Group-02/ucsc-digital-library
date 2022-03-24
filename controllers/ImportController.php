<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Collection;
use app\models\Community;
use app\models\Content;
use app\models\ContentCreator;
use app\models\ContentKeyword;
use app\models\FileDelete;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class ImportController extends Controller
{
    public function importCollection(Request $request)
    {
        $community =  new Community();
        if ($request->isPOST()) {
            $data = [];
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (!$community->findOne(['community_id' => $data['community_id']])) {
                // var_dump($data);
                throw new NotFoundException();
            }

            $community = $community->findOne(['community_id' => $data['community_id']]);

            $form_input = $request->getBody();


            $file = $_FILES['collection-zip-file'];
            // var_dump($file);

            $path = 'temp/';
            $location = $path . $file['name'];

            // var_dump($file);

            if (move_uploaded_file($file['tmp_name'], $location)) {
                $zip = new ZipArchive();
                if ($zip->open($location)) {
                    $zip->extractTo($path);
                    $zip->close();
                }
            }

            $name_arr = explode(".", $location);

            //read the csv file
            $csv_name =  "temp/metadata.csv";

            $fp = fopen($csv_name, "r");

            if ($fp === false) {
                die('Error opening the file ' . $csv_name);
            }

            $row = 1;

            $row = 0;

            $name_arr = explode(".", $file['name']);
            $collection_name = $name_arr[0];

            $collection = new Collection();

            $data = fgetcsv($fp);
            $headings = $data;
            $data = fgetcsv($fp);
            $collection_description = $data[0] ?? "";

            $collection->name = $collection_name;
            $collection->description = $collection_description;
            $collection->community_id = $community->community_id;

            $collection->save();

            $new_collection_id = Application::$app->db->pdo->lastInsertId();

            while (($data = fgetcsv($fp)) !== FALSE) {
                $content = new Content();
                $content->title = $data[array_search("title", $headings)];
                $content->subject = $data[array_search("subject", $headings)];
                $content->date = $data[array_search("date", $headings)];
                $content->language = $data[array_search("language", $headings)];
                $content->type = $data[array_search("type", $headings)];
                $content->publish_state = $data[array_search("publish_state", $headings)];
                $content->collection_id = $new_collection_id;
                $content->upload_steps = $data[array_search("upload_steps", $headings)];
                $content->isbn = $data[array_search("isbn", $headings)];
                $content->abstract = $data[array_search("abstract", $headings)];
                $content->publisher = $data[array_search("publisher", $headings)];

                $content->save();
                $new_content_id = Application::$app->db->pdo->lastInsertId();

                //find the content in the folder
                $name_arr = explode(".", $location);
                $contents = scandir($name_arr[0] . "/content");

                $file_path = "";
                $content_hash = $data[array_search("content_hash", $headings)];

                foreach ($contents as $content_now) {
                    $file_hash = hash_file("sha256", $name_arr[0] . "/content/" . $content_now);

                    if ($file_hash === $content_hash) {
                        $file_path = $name_arr[0] . "/content/" . $content_now;
                    }
                }

                $saved_content = new Content();

                $saved_content = $saved_content->findOne(['content_id' => $new_content_id]);

                $temp = explode(".", $file_path);
                $newfilename = $new_content_id . '.' . end($temp);


                $file['name'] = $newfilename;
                if ($file_path === "") $saved_content->url = "";
                else $saved_content->url = "data/content/uploads/" . $file['name'];

                $saved_content->update();

                if ($file_path !== "") copy($file_path, $saved_content->url);

                //insert creators
                $creators = $data[array_search("creators", $headings)];
                $creators = explode(", ", $creators);
                foreach ($creators as $creator) {
                    $content_creator = new ContentCreator();
                    $content_creator->content_id = $new_content_id;
                    $content_creator->creator = $creator;

                    $content_creator->save();
                }
                // var_dump($creators);

                //insert keywords
                $keywords = $data[array_search("keywords", $headings)];
                $keywords = explode(", ", $keywords);
                foreach ($keywords as $keyword) {
                    $content_keyword = new ContentKeyword();
                    $content_keyword->content_id = $new_content_id;
                    $content_keyword->keyword = $keyword;

                    $content_keyword->save();
                }
                // var_dump($keywords);
            }

            fclose($fp);

            $delete_directory =  new FileDelete();

            $delete_directory->rrmdir('temp');
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS,
                self::BREADCRUM_IMPORT_COLLECTION
            ];

            Application::$app->session->setFlashMessage('success', 'Successfully imported the collection');
            return $this->render("admin/content/import-collection", ['breadcrum' => $breadcrum]);
        } else {
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS,
                self::BREADCRUM_IMPORT_COLLECTION
            ];
            return $this->render("admin/content/import-collection", ['breadcrum' => $breadcrum]);
        }
    }
}
