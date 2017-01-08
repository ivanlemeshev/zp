<?php

namespace App\Controller;

use App\Service\Cache\CacheInterface;
use App\Service\ReportBuilder;
use App\Service\Storage;
use Silex\Application;

class ReportController
{
    public function topOfJobsByRubric(Application $app)
    {
        /** @var CacheInterface $cache */
        $cache = $app['services']['cache'];
        $rubricsTop = $cache->get('rubricsTop');

        if (!$rubricsTop) {
            /** @var Storage $storage */
            $storage = $app['services']['storage'];
            $rubrics = $storage->getRubricsForTodayNewJobs($app['config']['geoId']);

            /** @var ReportBuilder $reportBuilder */
            $reportBuilder = $app['services']['reportBuilder'];
            $rubricsTop = $reportBuilder->buildTopOfJobsByRubricReport($rubrics);

            $cache->set('rubricsTop', $rubricsTop);
        }

        return $app['twig']->render('reports/top_of_jobs_by_rubric.twig', compact('rubricsTop'));
    }

    public function topOfWordsInJobTitles(Application $app)
    {
        /** @var CacheInterface $cache */
        $cache = $app['services']['cache'];
        $wordsTop = $cache->get('wordsTop');

        if (!$wordsTop) {
            /** @var Storage $storage */
            $storage = $app['services']['storage'];
            $jobs = $storage->getTodayNewJobs($app['config']['geoId']);

            /** @var ReportBuilder $reportBuilder */
            $reportBuilder = $app['services']['reportBuilder'];
            $wordsTop = $reportBuilder->buildTopOfWordsInJobTitlesReport($jobs);

            $cache->set('wordsTop', $wordsTop);
        }

        return $app['twig']->render('reports/top_of_words_in_job_titles.twig', compact('wordsTop'));
    }
}
