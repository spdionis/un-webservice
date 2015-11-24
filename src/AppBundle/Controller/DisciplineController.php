<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Discipline;
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

class DisciplineController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Get("/{discipline}", requirements={"discipline" = "\d+"})
     * @ApiDoc()
     *
     * @ParamConverter("discipline", class="AppBundle:Discipline")
     *
     * @param Discipline $discipline
     * @return Discipline
     */
    public function getAction(Discipline $discipline)
    {
        return $discipline;
    }

    /**
     * @Get("")
     * @ApiDoc()
     *
     * @QueryParam(name="page", description="Page, 0-indexed.", default=0, requirements="\d+")
     * @QueryParam(name="per_page", description="Elements per page. Maximum 1000.", default=10, requirements="\d+")
     *
     * @param ParamFetcherInterface $paramFetcher
     * @return PaginatedResource
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        $handler = $this->get('un.discipline_handler');

        $page = (int) $paramFetcher->get('page');
        $perPage = (int) $paramFetcher->get('per_page');

        $paginator = $handler->getPaginated($page, $perPage);

        return PaginatedResourceFactory::fromPaginator($paginator, $page);
    }

    /**
     * @Post("")
     * @ApiDoc(
     *  input="AppBundle\Form\DisciplineForm"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $handler = $this->get('un.discipline_handler');

        /** @var Discipline $discipline */
        $discipline = $handler->post($request->request->all());

        $data = [
            'resource_id' => $discipline->getId(),
            '_link' => $this->route($discipline),
        ];

        return View::create($data, Response::HTTP_CREATED);
    }

    /**
     * @Patch("/{discipline}", requirements={"discipline" = "\d+"})
     *
     * @ApiDoc(
     *     input="AppBundle\Form\DisciplineForm"
     * )
     *
     * @ParamConverter("discipline", class="AppBundle:Discipline")
     *
     * @param Request $request
     * @param Discipline $discipline
     * @return array
     */
    public function patchAction(Request $request, Discipline $discipline)
    {
        $handler = $this->get('un.discipline_handler');

        /** @var Discipline $discipline */
        $discipline = $handler->patch($request->request->all(), $discipline);

        return [
            'resource_id' => $discipline->getId(),
            '_link' => $this->route($discipline),
        ];
    }

    /**
     * @Delete("/{discipline}", requirements={"discipline" = "\d+"})
     * @ApiDoc()
     *
     * @ParamConverter("discipline", class="AppBundle:Discipline")
     *
     * @param Discipline $discipline
     */
    public function deleteAction(Discipline $discipline)
    {
        $this->get('un.discipline_handler')->delete($discipline);
    }

    private function route(Discipline $discipline)
    {
        return $this->get('router')->generate('api_1_get_discipline', ['discipline' => $discipline->getId()]);
    }
}