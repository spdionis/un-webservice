<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Course;
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

class CourseController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Get("/{course}", requirements={"course" = "\d+"})
     * @ApiDoc()
     *
     * @ParamConverter("course", class="AppBundle:Course")
     *
     * @param Course $course
     * @return Course
     */
    public function getAction(Course $course)
    {
        return $course;
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
        $handler = $this->get('un.course_handler');

        $page = (int) $paramFetcher->get('page');
        $perPage = (int) $paramFetcher->get('per_page');

        $paginator = $handler->getPaginated($page, $perPage);

        return PaginatedResourceFactory::fromPaginator($paginator, $page);
    }

    /**
     * @Post("")
     * @ApiDoc(
     *  input="AppBundle\Form\CourseForm"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $handler = $this->get('un.course_handler');

        /** @var Course $course */
        $course = $handler->post($request->request->all());

        $data = [
            'resource_id' => $course->getId(),
            '_link' => $this->route($course),
        ];

        return View::create($data, Response::HTTP_CREATED);
    }

    /**
     * @Patch("/{course}", requirements={"course" = "\d+"})
     *
     * @ApiDoc(
     *     input="AppBundle\Form\CourseForm"
     * )
     *
     * @ParamConverter("course", class="AppBundle:Course")
     *
     * @param Request $request
     * @param Course $course
     * @return array
     */
    public function patchAction(Request $request, Course $course)
    {
        $handler = $this->get('un.course_handler');

        /** @var Course $course */
        $course = $handler->patch($request->request->all(), $course);

        return [
            'resource_id' => $course->getId(),
            '_link' => $this->route($course),
        ];
    }

    /**
     * @Delete("/{course}", requirements={"course" = "\d+"})
     * @ApiDoc()
     *
     * @ParamConverter("course", class="AppBundle:Course")
     *
     * @param Course $course
     */
    public function deleteAction(Course $course)
    {
        $this->get('un.course_handler')->delete($course);
    }

    private function route(Course $course)
    {
        return $this->get('router')->generate('api_1_get_course', ['course' => $course->getId()]);
    }
}