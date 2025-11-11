<?php

class ElasticSearchIndexerCommand extends CConsoleCommand {

    protected $batchSize = 500;

    public function run($args) {
        Yii::import('front.modules.elasticsearch.components.Base', true);
        Yii::import('front.modules.elasticsearch.components.Indexer', true);
        Yii::import('composer.autoload', true);

        $indexer = new Elastic\Indexer();
        $indexer->initServer(ELASTIC_SERVER_HOST, ELASTIC_SERVER_PORT, ELASTIC_INDEX_NAME, ELASTIC_TYPE_NAME);
        $indexer->initSettings($this->batchSize, array('content'));

        if (ELASTIC_INDEX_SOURCE == 'db') {
            $this->fillFromDb( $indexer );
        }
        else {
            $this->fillFromHtml( $indexer );
        }
    }

    /** ссылки должны быть полные (с доменом) */
    protected function fillFromHtml($indexer) {
        Yii::import('ext.PhpSimpleHtmlDomParser.simple_html_dom', true);

        $html = file_get_html(ELASTIC_SITE_MAP_URL);
        $siteMapLinks = $html->find(ELASTIC_SITE_MAP_SELECTOR);


        $indexer->run(
            // closure which adds batch of entries to index
            function($offset, $limit) use ($siteMapLinks) {
                $result = array();
                $end = min( $offset+$limit, count($siteMapLinks) );

                for ($i=$offset; $i<$end; $i++) {
                    $link = $siteMapLinks[$i];
                    $page = file_get_html($link->href);

                    if ($page) {
                        $foundName = $page->find(ELASTIC_TITLE_SELECTOR, 0);
                        $foundContent = $page->find(ELASTIC_CONTENT_SELECTOR, 0);

                        $result[] = array(
                            'name' => $foundName ? $foundName->plaintext : '',
                            'content' => $foundContent ? preg_replace("/\s+/u", " ", $foundContent->plaintext) : '',
                            'route' => $link->href,
                        );
                    }
                }

                return $result;
            }
        );
    }

    protected function fillFromDb($indexer) {
        Yii::import('front.modules.sections.models.Sections');

        $model = Sections::model();

        $indexer->run(
            // closure which adds batch of entries to index
            function($offset, $limit) use ($model) {
                $criteria = new CDbCriteria;
                $criteria->compare('active', 1);
                $criteria->offset = $offset;
                $criteria->limit = $limit;

                return $model->findAll($criteria);
            }
        );
    }


}
