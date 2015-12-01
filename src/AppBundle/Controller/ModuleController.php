<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Module;
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

class ModuleController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Get("/{module}", requirements={"modules" = "\d+"})
     * @ApiDoc()
     *
     * @ParamConverter("module", class="AppBundle:Module")
     *
     * @param Module $module
     * @return Module
     */
    public function getAction(Module $module)
    {
        return $module;
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
        $handler = $this->get('un.module_handler');

        $page = (int) $paramFetcher->get('page');
        $perPage = (int) $paramFetcher->get('per_page');

        $paginator = $handler->getPaginated($page, $perPage);

        return PaginatedResourceFactory::fromPaginator($paginator, $page);
    }

    /**
     * @Post("")
     * @ApiDoc(
     *  input="AppBundle\Form\ModuleForm"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $handler = $this->get('un.module_handler');

        /** @var Module $module */
        $module = $handler->post($request->request->all());

        $data = [
            'resource_id' => $module->getId(),
            '_link' => $this->route($module),
        ];

        return View::create($data, Response::HTTP_CREATED);
    }

    /**
     * @Patch("/{module}", requirements={"module" = "\d+"})
     *
     * @ApiDoc(
     *     input="AppBundle\Form\ModuleForm"
     * )
     *
     * @ParamConverter("module", class="AppBundle:Module")
     *
     * @param Request $request
     * @param Module $module
     * @return array
     */
    public function patchAction(Request $request, Module $module)
    {
        $handler = $this->get('un.module_handler');

        /** @var Module $module */
        $module = $handler->patch($request->request->all(), $module);

        return [
            'resource_id' => $module->getId(),
            '_link' => $this->route($module),
        ];
    }

    /**
     * @Delete("/{module}", requirements={"module" = "\d+"})
     * @ApiDoc()
     *
     * @ParamConverter("module", class="AppBundle:Module")
     *
     * @param Module $module
     */
    public function deleteAction(Module $module)
    {
        $this->get('un.module_handler')->delete($module);
    }

    private function route(Module $module)
    {
        return $this->get('router')->generate('api_1_get_module', ['module' => $module->getId()]);
    }
}