<?php

namespace app\models;

use app\core\Application;

class Citation
{

    public Content $content;
    public string $title;
    public string $publisher;
    public string $authorsList;
    public string $publishYear;
    public string $shareLink;
    public int $lastAccessDate;
    public string $lastAccessMonth;
    public int $lastAccessYear;

    public function __construct($contentId)
    {
        $contentModel = new Content();
        $contentCreatorModel = new ContentCreator();
        $content = $contentModel->findOne(["content_id" => $contentId]);
        $reg_no = Application::$app->user->reg_no;
        $contentViewRecordsModel = new ContentViewRecords();
        $contentViewRecord = $contentViewRecordsModel->getLatestRecord(["content_id" => $content->content_id]);
        // var_dump($contentViewRecord[0]->timestamp);

        $authors = $contentCreatorModel->findContentAuthors($content->content_id);
        $this->title = $content->title;
        $this->publisher = $content->publisher;
        $this->publishYear = date("Y", strtotime($content->date));
        $this->shareLink = "http://localhost:8000/content?content_id=" . $content->content_id;
        if ($contentViewRecord) {
            $lastAccess = $contentViewRecord[0]->timestamp;
            $this->lastAccessDate = date("d", strtotime($lastAccess));
            $this->lastAccessMonth = date("M", strtotime($lastAccess));
            $this->lastAccessYear = date("Y", strtotime($lastAccess));
        }
        $authorsNames = [];
        foreach ($authors as $author) {
            array_push($authorsNames, $author->creator);
        }
        $this->authorsList = implode(", ", $authorsNames);
        // var_dump($this->authorsList);
    }

    public function eBooks($citationType)
    {
        // Author(s) Initial(s). Surname(s), Title of the E-book, xth ed. City of Publisher, (U.S. State or Country if the City is not ‘well known’): Publisher, Year of Publication, pp. xxx–xxx. Accessed on: Abbreviated Month Day, Year.​ [Online]. Available: site/path/file (doi:xxxxx, database or URL)
        if ($citationType == 1) {
            $citation = $this->authorsList . ", " . $this->title . ". " . (($this->publisher) ? ($this->publisher . ", ") : "") . ($this->publishYear ? ($this->publishYear . ". ") : "") . ($this->lastAccessMonth ? ("Accessed on: " . $this->lastAccessMonth . ". " . $this->lastAccessDate . ", " . $this->lastAccessYear . ". ") : "") . "[Online]. Available: " . $this->shareLink;
        } else {
            $citation = $this->authorsList . ". " . ($this->publishYear ? ($this->publishYear . ". ") : "") . $this->title . ". " . (($this->publisher) ? ($this->publisher . ". ") : "");
        }
        return $citation;
    }

    public function thesis($citationType)
    {
        if ($citationType == 1) {
            $citation = $this->authorsList . ", \"" . $this->title . "\"" . (($this->publisher) ? (", " . $this->publisher) : "") . ($this->publishYear ? (", " . $this->publishYear) : "") . ". [Online]. " . "Available: " . $this->shareLink;
        } else {
            $citation = $this->authorsList . ", " . ($this->publishYear ? ($this->publishYear . ". ") : "") . $this->title . ". ";
        }
        return $citation;
    }

    public function publications($citationType)
    {
        if ($citationType == 1) {
            $citation = $this->authorsList . ", " . $this->title . ". " . (($this->publisher) ? ($this->publisher . ", ") : "") . ($this->publishYear ? ($this->publishYear . ". ") : "") . ($this->lastAccessMonth ? ("Accessed on: " . $this->lastAccessMonth . ". " . $this->lastAccessDate . ", " . $this->lastAccessYear . ". ") : "") . "[Online]. Available: " . $this->shareLink;
        } else {
            $citation = $this->authorsList . ". " . ($this->publishYear ? ($this->publishYear . ". ") : "") . $this->title . ". " . (($this->publisher) ? ($this->publisher . ". ") : "");
        }
        return $citation;
    }

    // public function pastPapers($citationType)
    // {
    //     if ($citationType == 1) {
    //         $citation = $this->authorsList. ", '". $this->title. "'" . ($this->publishYear?(", ".$this->publishYear):"") . ".";
    //     }
    //     return $citation;
    // }

    public function journals($citationType)
    {
        if ($citationType == 1) {
            $citation = $this->authorsList . ", '" . $this->title . "'" . ($this->publishYear ? (", " . $this->publishYear) : "") . ".";
        } else {
            //Author Surname, A., Year Published. Title. Publication Title, Volume number(Issue number), p.Pages Used.
            $citation = $this->authorsList . ", " . ($this->publishYear ? ($this->publishYear . ". ") : "") . $this->title . ". ";
        }
        return $citation;
    }

    public function newsletters($citationType)
    {
        // $citation = 
    }

    public function audio($citationType)
    {
        // $citation = 
    }

    public function video($citationType)
    {
        if ($citationType == 1) {
            // $citation = $this->authorsList. ", ". $this->title. ". " . (($this->publisher)?($this->publisher.", "):""). ($this->publishYear?($this->publishYear. ". "):"") .($this->lastAccessMonth?("Accessed on: ". $this->lastAccessMonth. ". ". $this->lastAccessDate. ", ". $this->lastAccessYear. ". "):""). "[Online]. Available: ". $this->shareLink;
        } else {
            //Author Surname, A., Year Published. Title,
            $citation = $this->authorsList . ", " . ($this->publishYear ? ($this->publishYear . ". ") : "") . $this->title . ". ";
        }
        return $citation;
    }

    // public function other($citationType)
    // {
    //     // $citation = 
    // }
}
