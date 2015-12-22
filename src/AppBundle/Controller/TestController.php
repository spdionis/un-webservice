<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Test;
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

class TestController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Get("/{test}", requirements={"test" = "\d+"})
     * @ApiDoc(
     *     section="Tests"
     * )
     *
     * @ParamConverter("test", class="AppBundle:Test")
     *
     * @param Test $module
     * @return Test
     */
    public function getAction(Test $module)
    {
        return $module;
    }

    /**
     * @Get("")
     * @ApiDoc(
     *     section="Tests"
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
        $handler = $this->get('un.test_handler');

        $page = (int) $paramFetcher->get('page');
        $perPage = (int) $paramFetcher->get('per_page');

        $paginator = $handler->getPaginated($page, $perPage);

        return PaginatedResourceFactory::fromPaginator($paginator, $page);
    }

    /**
     * @Post("")
     * @ApiDoc(
     *     section="Tests",
     *     input="AppBundle\Form\TestForm"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $handler = $this->get('un.test_handler');

        /** @var Test $module */
        $module = $handler->post($request->request->all());

        $data = [
            'resource_id' => $module->getId(),
            '_link' => $this->route($module),
        ];

        return View::create($data, Response::HTTP_CREATED);
    }

    /**
     * @Patch("/{test}", requirements={"test" = "\d+"})
     *
     * @ApiDoc(
     *     section="Tests",
     *     input="AppBundle\Form\TestForm"
     * )
     *
     * @ParamConverter("test", class="AppBundle:Test")
     *
     * @param Request $request
     * @param Test $module
     * @return array
     */
    public function patchAction(Request $request, Test $module)
    {
        $handler = $this->get('un.test_handler');

        /** @var Test $module */
        $module = $handler->patch($request->request->all(), $module);

        return [
            'resource_id' => $module->getId(),
            '_link' => $this->route($module),
        ];
    }

    /**
     * @Delete("/{test}", requirements={"test" = "\d+"})
     * @ApiDoc(
     *     section="Tests"
     * )
     *
     * @ParamConverter("test", class="AppBundle:Test")
     *
     * @param Test $module
     */
    public function deleteAction(Test $module)
    {
        $this->get('un.test_handler')->delete($module);
    }

    private function route(Test $module)
    {
        return $this->get('router')->generate('api_1_get_module', ['test' => $module->getId()]);
    }
}