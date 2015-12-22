<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Topic;
use AppBundle\Helper\PaginatedResource;
use AppBundle\Helper\PaginatedResourceFactory;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TopicController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Get("/{topic}", requirements={"topic" = "\d+"})
     * @ApiDoc(
     *     section="Topics"
     * )
     *
     * @ParamConverter("topic", class="AppBundle:Topic")
     *
     * @param Topic $topic
     * @return Topic
     */
    public function getAction(Topic $topic)
    {
        return $topic;
    }

    /**
     * @Get("")
     * @ApiDoc(
     *     section="Topics"
     * )
     *
     * @QueryParam(name="page", description="Page, 0-indexed.", default=0, requirements="\d+")
     * @QueryParam(name="per_page", description="Elements per page. Maximum 1000.", default=10, requirements="\d+")
     *
     * @param ParamFetcherInterface $paramFetcher
     * @return PaginatedResource
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        $handler = $this->get('un.topic_handler');

        $page = (int) $paramFetcher->get('page');
        $perPage = (int) $paramFetcher->get('per_page');

        $paginator = $handler->getPaginated($page, $perPage);

        return PaginatedResourceFactory::fromPaginator($paginator, $page);
    }

    /**
     * @Post("")
     * @ApiDoc(
     *     section="Topics",
     *     input="AppBundle\Form\TopicForm"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $handler = $this->get('un.topic_handler');

        /** @var Topic $topic */
        $topic = $handler->post($request->request->all());

        $data = [
            'resource_id' => $topic->getId(),
            '_link' => $this->route($topic),
        ];

        return View::create($data, Response::HTTP_CREATED);
    }

    /**
     * @Patch("/{topic}", requirements={"topic" = "\d+"})
     *
     * @ApiDoc(
     *     section="Topics",
     *     input="AppBundle\Form\TopicForm"
     * )
     *
     * @ParamConverter("topic", class="AppBundle:Topic")
     *
     * @param Request $request
     * @param Topic $topic
     * @return array
     */
    public function patchAction(Request $request, Topic $topic)
    {
        $handler = $this->get('un.topic_handler');

        /** @var Topic $topic */
        $topic = $handler->patch($request->request->all(), $topic);

        return [
            'resource_id' => $topic->getId(),
            '_link' => $this->route($topic),
        ];
    }

    /**
     * @Delete("/{topic}", requirements={"topic" = "\d+"})
     * @ApiDoc(
     *     section="Topics"
     * )
     *
     * @ParamConverter("topic", class="AppBundle:Topic")
     *
     * @param Topic $topic
     */
    public function deleteAction(Topic $topic)
    {
        $this->get('un.topic_handler')->delete($topic);
    }

    private function route(Topic $topic)
    {
        return $this->get('router')->generate('api_1_get_topic', ['topic' => $topic->getId()]);
    }


}