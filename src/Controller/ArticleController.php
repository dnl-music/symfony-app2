<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class PostController
 * @package App\Controller
 * @Route("/api", name="article_api")
 */
class ArticleController extends AbstractController
{
    /**
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     * @Route("/articles", name="articles", methods={"GET"})
     */
    public function getArticle(Request $request, ArticleRepository $articleRepository){
        $criteria = [];
        $year = $request->query->get('year');
        $month = $request->query->get('month');
        $tags = $request->query->get('tags');
        $page = $request->query->get('page') ?? 1;
        if($page < 1) {
            return $this->response(['message' => 'page must be greater than 0'], 400);
        }
        $per_page = 5;
        if($year xor $month) {
            return $this->response(['message' => 'Both year and month parameters must be provided'], 400);
        }
        $articleRepository->findDefault();
        if($year) {
            $articleRepository->findByMonthYear($month, $year);
        }
        if($tags) {
            $articleRepository->findByTags($tags);
        }

        $paginator = new Paginator(
            $articleRepository->getQueryBuilder()
                ->setFirstResult(($page - 1) * $per_page)
                ->setMaxResults($per_page),
            $fetchJoinCollection = true
        );

        $pages = intval(ceil(count($paginator) / $per_page));
        if($page > $pages) {
            return $this->response(['message' => 'Page Not Found'], 404);
        }
        $result['data'] = [];
        foreach($paginator as $row) {
            $result['data'][] = $row;
        }
        $result['current_page'] = $page;
        $result['pages'] = $pages;

        return $this->response($result);
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

}