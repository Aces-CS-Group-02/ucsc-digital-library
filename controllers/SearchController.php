<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Collection;
use app\models\Community;
use app\models\Content;
use app\core\BooleanSearchParser\src\Parser;
use app\models\ContentCreator;

class SearchController extends Controller
{
    public function searchResult(Request $request)
    {
        if ($request->isPOST()) {
        } else {

            $data = [];
            foreach ($_GET as $key => $value) {
                $data[$key] = $value;
            }

            $communities = [];
            array_push($communities, $data['community']);

            $collections = [];

            for ($i = 0; $i < count($communities); $i++) {
                $community = new Community();
                $collection = new Collection();

                $c = $communities[$i];


                $collection = $collection->findAll(['community_id' => $c]);
                $community = $community->findAll(['parent_community_id' => $c]);

                foreach ($collection as $col) {
                    array_push($collections, $col['collection_id']);
                }

                foreach ($community as $com) {
                    array_push($communities, $com['community_id']);
                }
            }

            $parser = new Parser();
            $search_term = $parser->parse($data['search_query']);


            $search_query = "SELECT DISTINCT content.content_id, content.title, content.subject, content.abstract, content.date,
                        MAX(MATCH(content.title) AGAINST('{$search_term}' IN BOOLEAN MODE) +
                        MATCH(content.subject) AGAINST('{$search_term}' IN BOOLEAN MODE) +
                        MATCH(content.abstract) AGAINST('{$search_term}' IN BOOLEAN MODE) +
                        MATCH(content.publisher) AGAINST('{$search_term}' IN BOOLEAN MODE) +    
                        MATCH(content_creator.creator) AGAINST('{$search_term}' IN BOOLEAN MODE) +
                        MATCH(content_keyword.keyword) AGAINST('{$search_term}' IN BOOLEAN MODE)) as score
                        FROM content
                            LEFT JOIN content_creator ON content.content_id = content_creator.content_id
                            LEFT JOIN content_keyword ON content.content_id = content_keyword.content_id
                        WHERE
                            (MATCH(content.title) AGAINST('{$search_term}' IN BOOLEAN MODE)
                            OR MATCH(content.subject) AGAINST('{$search_term}' IN BOOLEAN MODE)
                            OR MATCH(content.abstract) AGAINST('{$search_term}' IN BOOLEAN MODE)
                            OR MATCH(content.publisher) AGAINST('{$search_term}' IN BOOLEAN MODE)
                            OR MATCH(content_creator.creator) AGAINST('{$search_term}' IN BOOLEAN MODE)
                            OR MATCH(content_keyword.keyword) AGAINST('{$search_term}' IN BOOLEAN MODE))
                    ";

            $creators = "";
            $titles = "";
            $subjects = "";

            $filters = [];

            for ($i = 0; $i < (count($data) - 5) / 3; $i++) {
                $type = $data["type{$i}"];
                $condition = $data["condition{$i}"];
                $query = $data["query{$i}"];

                $filters[$i]['type'] = $type;
                $filters[$i]['condition'] = $condition;
                $filters[$i]['query'] = $query;

                if ($condition != "not equals") {
                    if ($type == "title") {
                        $titles .= " +{$query}";
                    } elseif ($type == "author") {
                        $creators .= " +{$query}";
                    } elseif ($type == "subject") {
                        $subjects .= " +{$query}";
                    }
                } else {
                    if ($type == "title") {
                        $titles .= " -{$query}";
                    } elseif ($type == "author") {
                        $creators .= " -{$query}";
                    } elseif ($type == "subject") {
                        $subjects .= " -{$query}";
                    }
                }
            }

            if ($creators != "") {
                $search_query .= " AND MATCH(content_creator.creator) AGAINST('{$creators}')";
            }

            if ($subjects != "") {
                $search_query .= " AND MATCH(content.subject) AGAINST('{$subjects}')";
            }

            if ($titles != "") {
                $search_query .= " AND MATCH(content.title) AGAINST('{$titles}')";
            }

            $in_collection = "(";

            if ($data['community'] != -1) {
                if (count($collections) > 0) {
                    $in_collection .= "{$collections[0]}";
                    for ($i = 1; $i < count($collections); $i++) {
                        $in_collection .= ",{$collections[$i]}";
                    }
                    $in_collection .= ")";
                    $search_query .= " AND content.collection_id IN {$in_collection}";
                }
            }

            $search_query .= " GROUP BY content.content_id 
            ORDER BY ";

            if($data['sort_by']=='relavance')
            {
                $search_query.="score "; 
            }elseif($data['sort_by']=='title')
            {
                $search_query.="content.title "; 
            }elseif($data['sort_by']=='date')
            {
                $search_query.="content.date "; 
            }

            if($data['order']=='asc')
            {
                $search_query.="ASC";
            }elseif($data['order']=='desc')
            {
                $search_query.="DESC";
            }

            $page = isset($data['page']) ? $data['page'] : 1;
            $limit  = 1;
            $start = ($page - 1) * $limit;

            $content = new Content();

            $content = $content->paginate($search_query, $start, $limit);

            foreach ($content->payload as $c) {
                $content_creators = new ContentCreator();

                $content_creators = $content_creators->findAll(['content_id' => $c->content_id]);

                $c->creators = $content_creators;
            }

            $communities = new Community();

            $communities = $communities->getAllTopLevelCommunities(0, 100000);

            // echo '<pre>';
            // var_dump($search_query);
            // var_dump($data);

            // echo '</pre>';

            return $this->render("search-result", ['communities' => $communities, 'contents' => $content->payload, 'pageCount' => $content->pageCount, 'currentPage' => $page, 'filters'=>$filters, 'data' => $data]);
        }
    }

    public function advancedSearch(Request $request)
    {
        if ($request->isPOST()) {
        } else {
            $communities = new Community();

            $communities = $communities->getAllTopLevelCommunities(0, 100000);

            return $this->render("advanced-search", ['communities' => $communities]);
        }
    }
}






//split karala or and danna gahapu eka

// $split_and = preg_split('/ (AND) /', $data['search_query']);

//             $addthis = "AND";
//             $after_split_and = array_reduce(
//                 array_map(
//                     function ($i) use ($addthis) {
//                         return count($i) == 1 ? array_merge($i, array($addthis)) : $i;
//                     },
//                     array_chunk($split_and, 1)
//                 ),
//                 function ($r, $i) {
//                     return array_merge($r, $i);
//                 },
//                 array()
//             );

//             array_pop($after_split_and);

//             $or = [];

//             foreach ($after_split_and as $n) {
//                 $split_or = preg_split('/ (OR) /', $n);
//                 $addthis = "OR";

//                 $after_split_or = array_reduce(
//                     array_map(
//                         function ($i) use ($addthis) {
//                             return count($i) == 1 ? array_merge($i, array($addthis)) : $i;
//                         },
//                         array_chunk($split_or, 1)
//                     ),
//                     function ($r, $i) {
//                         return array_merge($r, $i);
//                     },
//                     array()
//                 );

//                 array_pop($after_split_or);

//                 foreach ($after_split_or as $k) {
//                     array_push($or, $k);
//                 }
//             }

//             $left_bracket = [];

//             foreach ($or as $n) {
//                 $split_or = preg_split('/(\()/', $n);
//                 $addthis = "(";

//                 var_dump($split_or);

//                 $after_split_l = array_reduce(
//                     array_map(
//                         function ($i) use ($addthis) {
//                             return count($i) == 1 ? array_merge($i, array($addthis)) : $i;
//                         },
//                         array_chunk($split_or, 1)
//                     ),
//                     function ($r, $i) {
//                         return array_merge($r, $i);
//                     },
//                     array()
//                 );

//                 array_pop($after_split_l);

//                 foreach ($after_split_l as $k) {
//                     if ($k != "") array_push($left_bracket, $k);
//                 }
//             }

//             $final = [];

//             foreach ($left_bracket as $n) {
//                 $split_or = preg_split('/(\))/', $n);
//                 $addthis = ")";

//                 var_dump($split_or);

//                 $after_split_r = array_reduce(
//                     array_map(
//                         function ($i) use ($addthis) {
//                             return count($i) == 1 ? array_merge($i, array($addthis)) : $i;
//                         },
//                         array_chunk($split_or, 1)
//                     ),
//                     function ($r, $i) {
//                         return array_merge($r, $i);
//                     },
//                     array()
//                 );

//                 array_pop($after_split_r);

//                 foreach ($after_split_r as $k) {
//                     if ($k != "") array_push($final, $k);
//                 }
//             }
