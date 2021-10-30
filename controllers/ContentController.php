<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class ContentController extends Controller
{
    public function selectCollection(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/select-collection", ['breadcrum' => $breadcrum]);
    }

    public function insertMetaData(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/insert-metadata", ['breadcrum' => $breadcrum]);

    }

    public function insertKeywordAbstract(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/insert-keyword-abstract", ['breadcrum' => $breadcrum]);

    }

    public function submitContent(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/submit-content", ['breadcrum' => $breadcrum]);

    }

    public function verifySubmission(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/verify-submission", ['breadcrum' => $breadcrum]);

    }
}