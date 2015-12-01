<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Chapter;
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

class ChapterController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Get("/{chapter}", requirements={"chapter" = "\d+"})
     * @ApiDoc(
     *     section="Chapters"
     * )
     *
     * @ParamConverter("chapter", class="AppBundle:Chapter")
     *
     * @param Chapter $chapter
     * @return Chapter
     */
    public function getAction(Chapter $chapter)
    {
        return $chapter;
    }

    /**
     * @Get("")
     * @ApiDoc(
     *     section="Chapters"
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
        $handler = $this->get('un.chapter_handler');

        $page = (int) $paramFetcher->get('page');
        $perPage = (int) $paramFetcher->get('per_page');

        $paginator = $handler->getPaginated($page, $perPage);

        return PaginatedResourceFactory::fromPaginator($paginator, $page);
    }

    /**
     * @Post("")
     * @ApiDoc(
     *    section="Chapters",
     *    input="AppBundle\Form\ChapterForm"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $handler = $this->get('un.chapter_handler');

        /** @var Chapter $chapter */
        $chapter = $handler->post($request->request->all());

        $data = [
            'resource_id' => $chapter->getId(),
            '_link' => $this->route($chapter),
        ];

        return View::create($data, Response::HTTP_CREATED);
    }

    /**
     * @Patch("/{chapter}", requirements={"chapter" = "\d+"})
     *
     * @ApiDoc(
     *     section="Chapters",
     *     input="AppBundle\Form\ChapterForm"
     * )
     *
     * @ParamConverter("chapter", class="AppBundle:Chapter")
     *
     * @param Request $request
     * @param Chapter $chapter
     * @return array
     */
    public function patchAction(Request $request, Chapter $chapter)
    {
        $handler = $this->get('un.chapter_handler');

        /** @var Chapter $chapter */
        $chapter = $handler->patch($request->request->all(), $chapter);

        return [
            'resource_id' => $chapter->getId(),
            '_link' => $this->route($chapter),
        ];
    }

    /**
     * @Delete("/{chapter}", requirements={"chapter" = "\d+"})
     * @ApiDoc(
     *     section="Chapters"
     * )
     *
     * @ParamConverter("chapter", class="AppBundle:Chapter")
     *
     * @param Chapter $chapter
     */
    public function deleteAction(Chapter $chapter)
    {
        $this->get('un.chapter_handler')->delete($chapter);
    }

    private function route(Chapter $chapter)
    {
        return $this->get('router')->generate('api_1_get_chapter', ['chapter' => $chapter->getId()]);
    }
}