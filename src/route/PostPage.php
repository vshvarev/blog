<?php

namespace Blog\Route;

use Blog\PostMapper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;

class PostPage
{
    /**
     * @var Environment
     */
    private Environment $view;

    /**
     * @var PostMapper
     */
    private PostMapper $postMapper;

    /**
     * @param Environment $view
     * @param PostMapper $postMapper
     */
    public function __construct(Environment $view, PostMapper $postMapper)
    {
        $this->view = $view;
        $this->postMapper = $postMapper;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $post = $this->postMapper->getByURLKey((string) $args['url_key']);

        if (empty($post)) {
            $body = $this->view->render('not-found.twig');
        } else {
            $body = $this->view->render('post.twig', [
                'post' => $post
            ]);
        }
        $response->getBody()->write($body);
        return $response;
    }
}