<?php


namespace AppBundle\Controller;


use AppBundle\Entity\BaseQuestion;
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

class BaseQuestionController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Get("/{question}", requirements={"question" = "\d+"})
     * @ApiDoc(
     *     section="Questions"
     * )
     *
     * @ParamConverter("question", class="AppBundle:BaseQuestion")
     *
     * @param BaseQuestion $question
     * @return BaseQuestion
     */
    public function getAction(BaseQuestion $question)
    {
        return $question;
    }

    /**
     * @Get("")
     * @ApiDoc(
     *     section="Questions"
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
        $handler = $this->get('un.base_question_handler');

        $page = (int) $paramFetcher->get('page');
        $perPage = (int) $paramFetcher->get('per_page');

        $paginator = $handler->getPaginated($page, $perPage);

        return PaginatedResourceFactory::fromPaginator($paginator, $page);
    }

    /**
     * @Post("")
     * @ApiDoc(
     *     section="Questions",
     *     input="AppBundle\Form\BaseQuestionForm"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $handler = $this->get('un.base_question_handler');

        /** @var BaseQuestion $question */
        $question = $handler->post($request->request->all());

        $data = [
            'resource_id' => $question->getId(),
            '_link' => $this->route($question),
        ];

        return View::create($data, Response::HTTP_CREATED);
    }

    /**
     * @Patch("/{question}", requirements={"question" = "\d+"})
     *
     * @ApiDoc(
     *     section="Questions",
     *     input="AppBundle\Form\BaseQuestionForm"
     * )
     *
     * @ParamConverter("question", class="AppBundle:BaseQuestion")
     *
     * @param Request $request
     * @param BaseQuestion $question
     * @return array
     */
    public function patchAction(Request $request, BaseQuestion $question)
    {
        $handler = $this->get('un.base_question_handler');

        /** @var BaseQuestion $question */
        $question = $handler->patch($request->request->all(), $question);

        return [
            'resource_id' => $question->getId(),
            '_link' => $this->route($question),
        ];
    }

    /**
     * @Delete("/{question}", requirements={"question" = "\d+"})
     * @ApiDoc(
     *     section="Questions"
     * )
     *
     * @ParamConverter("question", class="AppBundle:BaseQuestion")
     *
     * @param BaseQuestion $question
     */
    public function deleteAction(BaseQuestion $question)
    {
        $this->get('un.base_question_handler')->delete($question);
    }

    private function route(BaseQuestion $question)
    {
        return $this->get('router')->generate('api_1_get_module', ['question' => $question->getId()]);
    }

}