<?php

namespace app\controllers;

use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Collection;
use app\models\Content;
use app\models\ContentCreator;
use app\models\ContentKeyword;
use ZipArchive;

class ExportController extends Controller
{
    public function exportCollection(Request $request)
    {
        $collection = new Collection();

        $data = $request->getBody();

        $collection = $collection->findOne(['collection_id' => $data['collection_id']]);

        if (!$collection) {
            throw new NotFoundException();
        }

        $content = new Content();

        $content_files = $content->findAllAsObjects(['collection_id' => $data['collection_id']]);


        //headers of the metadata csv file
        $data = [
            ['content_hash', 'title', 'subject', 'creators', 'keywords', 'date', 'language', 'type', 'publish_state', 'upload_steps', 'isbn', 'abstract', 'publisher', 'uploaded_by', 'approved']
        ];

        $description = [$collection->description];
        array_push($data, $description);

        //creating the zip file
        $zip_name = "$collection->name.zip";
        $zip = new ZipArchive();
        $zip->open($zip_name, ZipArchive::CREATE);

        //Getting all the metadata and adding files to the zip
        foreach ($content_files as $content_file) {

            $content_creators = new ContentCreator();
            $content_keywords = new ContentKeyword();

            $content_creators = $content_creators->findAllAsObjects(['content_id' => $content_file->content_id]);
            $content_keywords = $content_keywords->findAllAsObjects(['content_id' => $content_file->content_id]);

            $content_file->creators = $content_creators;
            $content_file->keywords = $content_keywords;

            //adding metadata to the csv file
            $creators = "";
            $keywords = "";

            $prefix = "";
            foreach ($content_file->creators as $creator) {
                $creators .= $prefix . $creator->creator;
                $prefix = ', ';
            }

            $prefix = "";
            foreach ($content_file->keywords as $keyword) {
                $keywords .= $prefix . $keyword->keyword;
                $prefix = ', ';
            }

            //creating the data row for each file
            $data_row = [];

            array_push($data_row, hash_file("sha256", $content_file->url));
            array_push($data_row, $content_file->title);
            array_push($data_row, $content_file->subject);
            array_push($data_row, $creators);
            array_push($data_row, $keywords);
            array_push($data_row, $content_file->date);
            array_push($data_row, $content_file->language);
            array_push($data_row, $content_file->type);
            array_push($data_row, $content_file->publish_state);
            array_push($data_row, $content_file->upload_steps);
            array_push($data_row, $content_file->isbn);
            array_push($data_row, $content_file->abstract);
            array_push($data_row, $content_file->publisher);
            array_push($data_row, $content_file->uploaded_by);
            array_push($data_row, $content_file->approved);

            //push the data row into the data
            array_push($data, $data_row);

            if ($content_file->url) {
                $zip->addFile($content_file->url, "content/" . basename($content_file->url));
            }
        }

        //creating the csv file for metadata
        $csv_name = "temp/metadata.csv";
        $fp = fopen($csv_name, 'w');

        if ($fp === false) {
            die('Error opening the file ' . $csv_name);
        }

        // var_dump($data);
        // exit;

        // write each row at a time to a file
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }

        // close the file
        fclose($fp);

        //add the csv file to the zip
        $zip->addFile($csv_name, "metadata.csv");


        $zip->close();

        //Download the zip file
        header("Content-Type: application/zip");
        header("Content-disposition: attachment; filename=$zip_name");
        header("Content-Length: " . filesize($zip_name));
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile($zip_name);

        // deleting the zip file from the file structure
        unlink($zip_name);
        //deleting the csv file
        unlink($csv_name);
    }
}
